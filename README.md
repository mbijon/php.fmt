php.fmt
=======

## Build statuses
- Master: [![Build Status](https://travis-ci.org/dericofilho/php.fmt.svg?branch=master)](https://travis-ci.org/dericofilho/php.fmt)

## Requirements
- PHP >= 5.5.0 to run the formatter. Note that the formatter can parse even a PHP file version 4 in case needed.

## Usage
```
    /bin/sh ./php.fmt filename|directory [...]
```

## Code Formatter's restrictions
- It doesn't parse properly ancient constructs like IF: ELSE: ENDIF; / SWITCH ... ENDSWITCH; and so on.
- It has a hard time looking ahead for tokens which disrupts the flow of the staments like:
```
	if // comment
	($condition) // comment
	// comment
	{
		doSomething();
	}

	or

	if // comment
	($condition) // comment
	// comment
	doSomething();
```
- It does not add implicit curly braces for block statements, like do..while, while, for and foreach
```
	if ($condition)
		$a;
	becomes
	if ($condition) {
		$a;
	}

	but

	if ($condition)
		do{
			doSomething()
		}while($condition2);
	does NOT become:
	if ($condition) {
		do{
			doSomething()
		}while($condition2);
	}
```

## Q&A
- Why does it not use nikic's [PHP-Parser](https://github.com/nikic/PHP-Parser)?
    First, I want to appraise nikic's PHP-Parser, it is an amazing piece of code. Having said that, it also does not handle correctly few edge cases.
    For instance, in test case 034-comments_breaking_syntax.in, although it parses correctly the non-comment part of the code, it also discards the two comments which render the code irregular if line breaks are not put properly.
    The whole idea of the formatter is to keep everything from the original inspection intact in the output, just rearranged.
    However, I do not discard it. I might use it to make possible the addition of automatic curly braces in single line blocks.