<?php

namespace Kiernan\Breadcrumbs;

use PHPUnit\Framework\TestCase;

/**
 * @covers Generator
 */
class GeneratorTest extends TestCase
{
    protected $generator;

    public function setUp()
    {
        $this->generator = new Generator();
    }

    public function testCanBeCreated()
    {
        $this->assertInstanceOf(Generator::class, new Generator());
    }

    public function testCanAddBreadcrumbWithUrl()
    {
        $text = 'Google';
        $url = 'http://google.com';
        $this->generator->add($text, $url);

        $crumbs = $this->generator->all();
        $crumb = isset($crumbs[0]) ? $crumbs[0] : '';

        $this->assertEquals(1, count($crumbs));
        $this->assertObjectHasAttribute('text', $crumb);
        $this->assertObjectHasAttribute('url', $crumb);
        $this->assertObjectHasAttribute('isActive', $crumb);
        $this->assertEquals($text, $crumb->text);
        $this->assertEquals($url, $crumb->url);
        $this->assertFalse($crumb->isActive);
    }

    public function testCanAddBreadcrumbWithoutUrl()
    {
        $text = 'Bing';
        $this->generator->add($text);

        $crumbs = $this->generator->all();
        $crumb = isset($crumbs[0]) ? $crumbs[0] : '';

        $this->assertEquals(1, count($crumbs));
        $this->assertObjectHasAttribute('text', $crumb);
        $this->assertObjectHasAttribute('url', $crumb);
        $this->assertObjectHasAttribute('isActive', $crumb);
        $this->assertEquals($text, $crumb->text);
        $this->assertNull($crumb->url);
        $this->assertTrue($crumb->isActive);
    }

    public function testCanAddMultipleBreadcrumbs()
    {
        $this->generator->addMany([
            ['Foo', 'http://foo.com'],
            ['Bar', 'http://bar.com'],
            ['Zed', 'http://zed.com'],
        ]);

        $crumbs = $this->generator->all();

        $this->assertEquals(3, count($crumbs));

        $this->assertEquals('Bar', $crumbs[1]->text);
    }
}
