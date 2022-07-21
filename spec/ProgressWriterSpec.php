<?php

namespace spec\Port\SymfonyConsole;

use Port\Reader\CountableReader;
use Symfony\Component\Console\Formatter\OutputFormatterInterface;
use Symfony\Component\Console\Output\OutputInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ProgressWriterSpec extends ObjectBehavior
{
    function let(OutputInterface $output, CountableReader $reader)
    {
        $this->beConstructedWith($output, $reader);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Port\SymfonyConsole\ProgressWriter');
    }

    function it_writes_items(CountableReader $reader, OutputInterface $output, OutputFormatterInterface $outputFormatter)
    {
        $outputFormatter->isDecorated()->willReturn(false);
        $outputFormatter->setDecorated(false)->willReturn();
        $outputFormatter->format(Argument::any())->willReturn(null);

        $reader->count()->willReturn(2);
        $output->isDecorated()->willReturn(true);
        $output->getFormatter()->willReturn($outputFormatter);
        $output->getVerbosity()->willReturn(OutputInterface::VERBOSITY_DEBUG);
        $output->write(Argument::type('string'))->shouldBeCalled();

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
