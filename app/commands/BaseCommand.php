<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

// source: http://kore1server.com/222/We+neede+more+colors+!+On+Artisan+commands+!!
class BaseCommand extends Command {

	private $styleDelimiter = '-';
	private $createdStyles = [];

	public function run(InputInterface $input, OutputInterface $output)
	{
		// Set extra colors.
		// The most problem is $output->getFormatter() don't work...
		// So create new formatter to add extra color.

		// ^ not true anymore

//		$formatter = new OutputFormatter( $output->isDecorated() );

//		$formatter = $output->getFormatter();
//		$formatter->setStyle( 'red', new OutputFormatterStyle( 'red', 'black' ) );
//		$formatter->setStyle( 'green', new OutputFormatterStyle( 'green', 'black' ) );
//		$formatter->setStyle( 'yellow', new OutputFormatterStyle( 'yellow', 'black' ) );
//		$formatter->setStyle( 'blue', new OutputFormatterStyle( 'blue', 'black' ) );
//		$formatter->setStyle( 'magenta', new OutputFormatterStyle( 'magenta', 'black' ) );
//		$formatter->setStyle( 'yellow-blue', new OutputFormatterStyle( 'yellow', 'blue' ) );
//		$output->setFormatter( $formatter );

		return parent::run($input, $output);
	}

	/**
	 * @override
	 * @param string $line
	 * @param null $style
	 * @throws Exception
	 */
	public function line($line, $style = null)
	{
		$format = '%s';

		if ($style !== null)
		{
			if (!$this->validStyle($style))
				throw new Exception($style . ' is not a valid style. Must be in the form "color" or "color-background"');

			if (!array_key_exists($style, $this->createdStyles))
			{
				$textColor = $this->getTextColor($style);
				$backgroundColor = $this->getBackgroundColor($style);

				$this->addStyles($textColor, $backgroundColor);
			}

			$format = '<' . $style . '>%s</' . $style . '>';
		}

		parent::line(sprintf($format, $line));
	}

	private function validStyle($style)
	{
		return preg_match('/^[a-z]+(-[a-z]+)?$/', $style);
	}

	private function getTextColor($style)
	{
		$color = $style;

		if (($pos = strpos($style, $this->styleDelimiter)) !== false)
			$color = substr($style, 0, $pos);

		return $color;
	}

	private function getBackgroundColor($style)
	{
		// default bg color
		$color = null;

		if (($pos = strpos($style, $this->styleDelimiter)) !== false)
			$color = substr($style, $pos + 1);

		return $color;
	}

	private function addStyles($textColor, $backgroundColor = null)
	{
		$style = $textColor;

		$style .= ($backgroundColor !== null) ? ($this->styleDelimiter . $backgroundColor) : '';

//		$this->error('adding style ... ' . $style);

		$this->createdStyles[$style] = [
			'text' => $textColor,
			'background' => $backgroundColor
		];

		$this->getOutput()->getFormatter()->setStyle($style, new OutputFormatterStyle($textColor, $backgroundColor));
	}

}