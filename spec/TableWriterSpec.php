<?php

namespace spec\Port\SymfonyConsole;

use Symfony\Component\Console\Helper\Table;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TableWriterSpec extends ObjectBehavior
{
    function let(Table $table)
    {
        $this->beConstructedWith($table);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Port\SymfonyConsole\TableWriter');
    }

    function it_writes_items(Table $table)
    {
        $table->addRow(Argument::type('array'))->shouldBeCalledTimes(2);
        $table->setHeaders(['first', 'second'])->shouldBeCalled();
        $table->render()->shouldBeCalled();

        $this->prepare();

        $this->writeItem([
            'first'  => 'The first',
            'second' => 'Second property',
        ]);

        $this->writeItem([
            'first'  => 'Another first',
            'second' => 'Last second',
        ]);

        $this->finish();
    }

    function it_handles_zero_items(Table $table)
    {
        $table->setHeaders([])->shouldBeCalled();
        $table->render()->shouldBeCalled();
        $this->finish();        
    }
}
