<?php

namespace PopCode\UserAuth\Adapters;

use Tymon\JWTAuth\Providers\Storage\IlluminateCacheAdapter as TymonIlluminateCacheAdapter;
use Illuminate\Cache\CacheManager;

class IlluminateCacheAdapter extends TymonIlluminateCacheAdapter
{
    /**
     * @{inheritdoc}
     */
    public function __construct(CacheManager $cache)
    {
        parent::__construct($cache);
    }

    /**
     * @{inheritdoc}
     */
    public function add($key, $value, $minutes)
    {
        parent::add($key, $value, $minutes);
    }

    /**
     * @{inheritdoc}
     */
    public function has($key)
    {
        return parent::has($key);
    }

    /**
     * @{inheritdoc}
     */
    public function destroy($key)
    {
        return parent::destroy($key);
    }

    /**
     * @{inheritdoc}
     */
    public function flush()
    {
        parent::flush();
    }

    /**
     * @{inheritdoc}
     */
    protected function cache()
    {
        return parent::cache();
    }
}
