<?php

use \HTMLBuilder\ElementFactory;
use \HTMLBuilder\Interfaces\InterfaceElements;

class ElementFactoryTest extends PHPUnit_Framework_TestCase
{

    public function testInstanceElement()
    {
        $this->assertInstanceOf(InterfaceElements::class, ElementFactory::make('tag'));
    }

    public function testCreateElement()
    {
        $t = ElementFactory::make('tag');

        $this->assertEquals('<tag></tag>', $t->render());
    }

    public function testCreateElementSimpleContent()
    {
        $t = ElementFactory::make('tag', 'Content tag');

        $this->assertEquals('<tag>Content tag</tag>', $t->render());
    }

    public function testCreateElementCompositeContent()
    {
        $t = ElementFactory::make('tag')->value(['Content tag', ElementFactory::make('tag')->value('Content tag')]);

        $this->assertEquals('<tag>Content tag<tag>Content tag</tag></tag>', $t->render());
    }

    public function testCreateElementWhithAttribute()
    {
        $t = ElementFactory::make('tag')->value('Content tag')->attr(['attr'=>['value1', 'value2']]);

        $this->assertEquals('<tag attr="value1 value2">Content tag</tag>', $t->render());
    }

    public function testCreateElementNestedContent()
    {
        $t = ElementFactory::make('tag')->value([ElementFactory::make('tag')->value([ElementFactory::make('tag')])]);

        $this->assertEquals('<tag><tag><tag></tag></tag></tag>', $t->render());
    }

    public function testCreateElementNoChild()
    {
        $t = ElementFactory::make('br');

        $this->assertEquals('<br>', $t->render());
    }

    public function testCreateElementNoChildWhitAttribute()
    {
        $t = ElementFactory::make('link')->att(['href'=>['path/to/file'], 'rel'=>['stylesheet']]);

        $this->assertEquals('<link href="path/to/file" rel="stylesheet">', $t->render());
    }
}