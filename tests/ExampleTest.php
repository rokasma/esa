<?php

namespace Rokasma\Esa\Tests;

use Orchestra\Testbench\TestCase;
use Rokasma\Esa\EsaServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [EsaServiceProvider::class];
    }
    
    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
