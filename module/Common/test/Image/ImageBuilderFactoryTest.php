<?php
namespace ShlinkioTest\Shlink\Common\Image;

use PHPUnit\Framework\TestCase;
use Shlinkio\Shlink\Common\Image\ImageBuilder;
use Shlinkio\Shlink\Common\Image\ImageBuilderFactory;
use Zend\ServiceManager\ServiceManager;

class ImageBuilderFactoryTest extends TestCase
{
    /**
     * @var ImageBuilderFactory
     */
    protected $factory;

    public function setUp()
    {
        $this->factory = new ImageBuilderFactory();
    }

    /**
     * @test
     */
    public function serviceIsCreated()
    {
        $instance = $this->factory->__invoke(new ServiceManager(), '');
        $this->assertInstanceOf(ImageBuilder::class, $instance);
    }
}
