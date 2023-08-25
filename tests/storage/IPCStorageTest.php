<?php

namespace bandwidthThrottle\tokenBucket\storage;

use PHPUnit\Framework\TestCase;

/**
 * Tests for IPCStorage.
 *
 * @author Markus Malkusch <markus@malkusch.de>
 * @link bitcoin:1335STSwu9hST4vcMRppEPgENMHD2r1REK Donations
 * @license WTFPL
 * @see  IPCStorage
 */
class IPCStorageTest extends TestCase
{

    /**
     * Tests building fails for an invalid key.
     *
     * @test
     */
    public function testBuildFailsForInvalidKey()
    {
        $this->expectException(StorageException::class);
        @new IPCStorage(-1);
    }

    /**
     * Tests remove() fails.
     *
     * @test
     */
    public function testRemoveFails()
    {
        $this->expectExceptionMessage("Could not release shared memory.");
        $this->expectException(StorageException::class);

        $storage = new IPCStorage(ftok(__FILE__, "a"));
        $storage->remove();
        @$storage->remove();
    }

    /**
     * Tests removing semaphore fails.
     *
     * @test
     */
    public function testfailRemovingSemaphore()
    {
        $this->expectExceptionMessage("Could not remove semaphore.");
        $this->expectException(StorageException::class);

        $key = ftok(__FILE__, "a");
        $storage = new IPCStorage($key);

        sem_remove(sem_get($key));
        @$storage->remove();
    }

    /**
     * Tests setMicrotime() fails.
     *
     * @test
     */
    public function testSetMicrotimeFails()
    {
        $this->expectException(StorageException::class);

        $storage = new IPCStorage(ftok(__FILE__, "a"));
        $storage->remove();
        @$storage->setMicrotime(123);
    }

    /**
     * Tests getMicrotime() fails.
     *
     * @test
     */
    public function testGetMicrotimeFails()
    {
        $this->expectException(StorageException::class);

        $storage = new IPCStorage(ftok(__FILE__, "b"));
        @$storage->getMicrotime();
    }
}
