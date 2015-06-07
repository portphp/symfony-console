<?php

namespace spec\Port\Console;

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\OutputInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ConsoleTableWriterSpec extends ObjectBehavior
{
    function let(OutputInterface $output, Table $table)
    {
        $this->beConstructedWith($output, $table);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Port\Console\ConsoleTableWriter');
    }

    function it_has_a_table(Table $table)
    {
        $this->getTable()->shouldReturn($table);
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
}
