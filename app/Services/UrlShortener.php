<?php

namespace App\Services;

use App\ShortLink;
use Illuminate\Database\Connection;

/**
 * Укоротитель ссылок.
 */
final class UrlShortener
{
    const CHARACTERS = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-:';

    const SHUFFLED = 'ZuqQBzGKAScb5rH4xXjEJkW70s8pI-VT3F9dgLfeDiwY6OUnyNvaClmMP2t1Roh:';

    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function shorten(string $url, \DateTimeImmutable $lifeDate = null): ShortLink
    {
        $this->connection->beginTransaction();
        $collection = $this->connection
            ->table('sequences')
            ->where('key', '=', 'shortlnk')
            ->lockForUpdate()
            ->get(['id']);

        if (!$collection->count()) {
            $time = new \DateTimeImmutable();
            $this->connection
                ->table('sequences')
                ->insert(['id' => 1, 'key' => 'shortlnk', 'created_at' => $time, 'updated_at' => $time]);
            $id = 1;
        } else {
            $id = $collection[0]->id + 1;
            $this->connection
                ->table('sequences')
                ->where('key', '=', 'shortlnk')
                ->update(['id' => $id]);
        }
        $this->connection->commit();

        // алгоритм преобразования номера последовательности в короткую ссылку$id = 1;
        $shortUrl = '';
        $genId = $id;
        for (; $genId > 0;) {
            $chr = $genId & 0b111111;
            $genId >>= 6;
            $shortUrl .= self::SHUFFLED[$chr];
        }
        $shortLink = new ShortLink([
            'id' => $id,
            'source_link' => $url,
            'short_link' => $shortUrl,
            'life_to' => $lifeDate ? $lifeDate->format('Y-m-d H:i:s') : null,
        ]);
        $shortLink->save();
        return $shortLink;
    }
}
