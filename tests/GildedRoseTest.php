<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Campusbokhandeln\Refactor\Item;
use Campusbokhandeln\Refactor\GildedRose;

class GildedRoseTest extends TestCase
{
    /** @test */
    public function it_works_without_conjured_items()
    {
        $items = [
            new Item('+5 Dexterity Vest', 10, 20),
            new Item('Aged Brie', 2, 0),
            new Item('Elixir of the Mongoose', 5, 7),
            new Item('Sulfuras, Hand of Ragnaros', 0, 80),
            new Item('Sulfuras, Hand of Ragnaros', -1, 80),
            new Item('Backstage passes to a TAFKAL80ETC concert', 15, 20),
            new Item('Backstage passes to a TAFKAL80ETC concert', 10, 49),
            new Item('Backstage passes to a TAFKAL80ETC concert', 5, 49),
        ];

        $output = $this->runForDays($items, 30);

        $this->assertEquals(file_get_contents(__DIR__ . '/fixtures/expected.txt'), $output);
    }

    /** @test */
    public function it_works_with_conjured_items()
    {
        $items = [
            new Item('+5 Dexterity Vest', 10, 20),
            new Item('Aged Brie', 2, 0),
            new Item('Elixir of the Mongoose', 5, 7),
            new Item('Sulfuras, Hand of Ragnaros', 0, 80),
            new Item('Sulfuras, Hand of Ragnaros', -1, 80),
            new Item('Backstage passes to a TAFKAL80ETC concert', 15, 20),
            new Item('Backstage passes to a TAFKAL80ETC concert', 10, 49),
            new Item('Backstage passes to a TAFKAL80ETC concert', 5, 49),
            // this conjured item does not work properly yet
            new Item('Conjured Mana Cake', 3, 6),
        ];

        $output = $this->runForDays($items, 30);

        $this->assertEquals(file_get_contents(__DIR__ . '/fixtures/expected_conjured.txt'), $output);
    }

    protected function runForDays(array $items, int $days)
    {
        $app = new GildedRose($items);
        $output = '';
        for ($i = 0; $i <= $days; $i++) {
            $output.= "-------- day ${i} --------" . PHP_EOL;
            $output.= 'name, sellIn, quality' . PHP_EOL;
            foreach ($items as $item) {
                $output.= $item . PHP_EOL;
            }
            $output.= PHP_EOL;
            $app->updateQuality();
        }

        return $output;
    }
}
