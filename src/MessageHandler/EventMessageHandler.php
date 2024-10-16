<?php declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\EventMessage;
use Psr\Log\LoggerInterface;
use Symfony\Component\Lock\LockFactory;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Contracts\Cache\CacheInterface;

#[AsMessageHandler]
class EventMessageHandler
{
    private LoggerInterface $logger;
    private LockFactory $lockFactory;
    private CacheInterface $cache;

    public function __construct(LoggerInterface $eventLogger, LockFactory $lockFactory, CacheInterface $cache)
    {
        $this->logger = $eventLogger;
        $this->lockFactory = $lockFactory;
        $this->cache = $cache;
    }

    public function __invoke(EventMessage $message): void
    {
        $accountId = $message->getAccountId();
        $eventData = $message->getEventData();
        $lock = $this->lockFactory->createLock('account_' . $accountId);

        // Максимальное количество попыток захвата блокировки
        $maxAttempts = 10;
        $attempt = 0;

        while (!$lock->acquire()) {
            if ($attempt >= $maxAttempts) {
                $this->logger->warning(
                    sprintf("Failed to acquire lock for account: %s after %d attempts", $accountId, $maxAttempts)
                );
                return;
            }
            $attempt++;
            sleep(1);
        }

        try {
            sleep(1);
            $currentDateTime = date('Y-m-d H:i:s');
            $logMessage = sprintf("[%s] Processed event for account: %s data: %s", $currentDateTime, $accountId, $eventData);
            $this->logger->info($logMessage);

            dump($logMessage . "\n");
        } finally {
            $lock->release();
        }
    }
}
