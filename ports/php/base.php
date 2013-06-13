<?php
/* Jison generated parser */

class Jison_Base
{
	public $symbols = array();
	public $terminals = array();
	public $productions = array();
	public $table = array();
	public $defaultActions = array();
	public $version = '0.3.12';
	public $debug = false;
	public $none = 0;
	public $shift = 1;
	public $reduce = 2;
	public $accept = 3;

	function trace()
	{

	}

	function parserPerformAction(&$thisS, $yytext, $yyleng, $yylineno, $yystate, $S, $_S, $O) {}

	function parserLex()
	{
		$token = $this->lexerLex(); // $end = 1
		$token = (isset($token) ? $token : 1);

		// if token isn't its numeric value, convert
		if (isset($this->symbols[$token]))
			return $this->symbols[$token];

		return $token;
	}

	function parseError($str = "", $hash = array())
	{
		throw new Exception($str);
	}

	function lexerError($str = "", $hash = array())
	{
		throw new Exception($str);
	}

	function parse($input)
	{
		if (empty($this->table)) {
			throw new Exception("Empty Table");
		}
		$stack = array(0);
		$stackCount = 1;
		$vstack = array(null);
		$vstackCount = 1;
		$yy = null;
		$_yy = null;
		$recovering = 0;
		$symbol = null;
		$action = null;
		$errStr = "";
		$preErrorSymbol = null;
		$state = null;

		$this->setInput($input);

		while (true) {
			// retreive state number from top of stack
			$state = $stack[$stackCount - 1];
			// use default actions if available
			if (isset($this->defaultActions[$state])) {
				$action = $this->defaultActions[$state];
			} else {
				if (empty($symbol) == true) {
					$symbol = $this->parserLex();
				}
				// read action for current state and first input
				if (isset($state) && isset($state->actions[$symbol->index])) {
					//$action = $this->table[$state][$symbol];
					$action = $state->actions[$symbol->index];
				} else {
					$action = null;
				}
			}

			if ($action == null) {
				if ($recovering > 0) {
					// Report error
					$expected = array();
					foreach($this->table[$state->index]->actions as $p => $item) {
						if (!empty($this->terminals[$p]) && $p > 2) {
							$expected[] = $this->terminals[$p];
						}
					}

					$errStr = "Parse error on line " . ($this->yy->lineNo + 1) . ":\n" . $this->showPosition() . "\nExpecting " . implode(", ", $expected) . ", got '" . (isset($this->terminals[$symbol]) ? $this->terminals[$symbol] : 'NOTHING') . "'";

					$this->parseError($errStr, array(
						"text"=> $this->match,
						"token"=> $symbol,
						"line"=> $this->yy->lineNo,
						"loc"=> $yy->loc,
						"expected"=> $expected
					));
				}
			}

			if ($state == null || $action == null) {
				break;
			}

			switch ($action->action) {
				case 1:
					// shift
					//$this->shiftCount++;
					$stack[] = new Jison_ParserCachedAction($symbol, $action);
					$stackCount++;

					$vstack[] = $this->yy;
					$vstackCount++;

					$symbol = "";
					if ($preErrorSymbol == null) { // normal execution/no error
						$yy = $this->yy;
						if ($recovering > 0) $recovering--;
					} else { // error just occurred, resume old lookahead f/ before error
						$symbol = $preErrorSymbol;
						$preErrorSymbol = null;
					}
					break;

				case 2:
					// reduce
					$len = $this->productions[$action->state->index]->len;
					// perform semantic action
					$_yy = $vstack[$vstackCount - $len];// default to $S = $1
					// default location, uses first token for firsts, last for lasts

					if ($this->range != null) {

					}

					$r = $this->parserPerformAction($_yy, $yy, $action->state->index, $vstack);

					if (isset($r)) {
						return $r;
					}

					// pop off stack
					if ($len > 0) {
						$stack = array_slice($stack, 0, -1 * $len * 2);
						$stackCount -= $len * 2;

						$vstack = array_slice($vstack, 0, -1 * $len);
						$vstackCount -= $len;
					}

					$stack[] = $this->productions[$action->state->index]->symbol; // push nonterminal (reduce)
					$stackCount++;

					$vstack[] = $_yy;
					$vstackCount++;

					$nextSymbol = $this->productions[$action->state->index]->symbol;
					// goto new state = table[STATE][NONTERMINAL]
					$nextState = $stack[$stackCount - 1]->action->state;
					$nextAction = $nextState->actions[$nextSymbol->index];

					$stack[] = new ParserCachedAction($nextSymbol, $nextAction);
					$stackCount++;

					break;

				case 3:
					// accept
					return true;
			}

		}

		return true;
	}


	/* Jison generated lexer */
	public $eof;
	public $yy = null;
	public $match = "";
	public $matched = "";
	public $conditionsStack = array();
	public $conditionStackCount = 0;
	public $rules = array();
	public $conditions = array();
	public $done = false;
	public $less;
	public $more;
	public $input;
	public $offset;
	public $ranges = array();
	public $flex = false;

	function __construct() {
		$this->eof = new Jison_ParserSymbol("Eof", 1);
	}


	function setInput($input)
	{
		$this->input = $input;
		$this->more = $this->less = $this->done = false;
		$this->yy = new Jison_ParserValue();
		$this->conditionStack = array('INITIAL');

		if (isset($this->options->ranges)) {
			$loc = $this->yy->loc = new Jison_ParserLocation();
			$loc->Range(new ParserRange(0, 0));
		} else {
			$this->yy->loc = new Jison_ParserLocation();
		}
		$this->offset = 0;
	}

	function input()
	{
		$ch = $this->input[0];
		$this->yy->text .= $ch;
		$this->yy->leng++;
		$this->offset++;
		$this->match .= $ch;
		$this->matched .= $ch;
		$lines = preg_match("/(?:\r\n?|\n).*/", $ch);
		if (count($lines) > 0) {
			$this->yy->lineNo++;
			$this->yy->lastLine++;
		} else {
			$this->yy->loc->lastColumn++;
		}
		if (isset($this->ranges)) {
			$this->yy->loc->range->y++;
		}

		$this->input = array_slice($this->input, 1);
		return $ch;
	}

	function unput($ch)
	{
		$len = strlen($ch);
		$lines = explode("/(?:\r\n?|\n)/", $ch);
		$linesCount = count($lines);

		$this->input = $ch . $this->input;
		$this->yy->text = substr($this->yy->text, 0, $len - 1);
		//$this->yylen -= $len;
		$this->offset -= $len;
		$oldLines = explode("/(?:\r\n?|\n)/", $this->match);
		$oldLinesCount = count($oldLines);
		$this->match = substr($this->match, 0, strlen($this->match) - 1);
		$this->matched = substr($this->matched, 0, strlen($this->matched) - 1);

		if (($linesCount - 1) > 0) $this->yy->lineNo -= $linesCount - 1;
		$r = $this->yy->loc->range;
		$oldLinesLength = (isset($oldLines[$oldLinesCount - $linesCount]) ? strlen($oldLines[$oldLinesCount - $linesCount]) : 0);

		$this->yy->loc = new ParserLocation(
			$this->yy->loc->firstLine,
			$this->yy->lineNo,
			$this->yy->loc->firstColumn,
			$this->yy->loc->firstLine,
			(empty($lines) ?
				($linesCount == $oldLinesCount ? $this->yy->loc->firstColumn : 0) + $oldLinesLength :
				$this->yy->loc->firstColumn - $len)
		);

		if (isset($this->ranges)) {
			$this->yy->loc->range = array($r[0], $r[0] + $this->yy->leng - $len);
		}
	}

	function more()
	{
		$this->more = true;
	}

	function pastInput()
	{
		$past = substr($this->matched, 0, strlen($this->matched) - strlen($this->match));
		return (strlen($past) > 20 ? '...' : '') . preg_replace("/\n/", "", substr($past, -20));
	}

	function upcomingInput()
	{
		$next = $this->match;
		if (strlen($next) < 20) {
			$next .= substr($this->input, 0, 20 - strlen($next));
		}
		return preg_replace("/\n/", "", substr($next, 0, 20) . (strlen($next) > 20 ? '...' : ''));
	}

	function showPosition()
	{
		$pre = $this->pastInput();

		$c = '';
		for($i = 0, $preLength = strlen($pre); $i < $preLength; $i++) {
			$c .= '-';
		}

		return $pre . $this->upcomingInput() . "\n" . $c . "^";
	}

	function next()
	{
		if ($this->done == true) {
			return $this->eof;
		}

		if (empty($this->input)) {
			$this->done = true;
		}

		if ($this->more == false) {
			$this->yy->text = '';
			$this->match = '';
		}

		$rules = $this->currentRules();
		for ($i = 0, $j = count($rules); $i < $j; $i++) {
			preg_match($this->rules[$rules[$i]], $this->input, $tempMatch);
			if ($tempMatch && (empty($match) || count($tempMatch[0]) > count($match[0]))) {
				$match = $tempMatch;
				$index = $i;
				if (isset($this->flex) && $this->flex == false) {
					break;
				}
			}
		}
		if ( $match ) {
			$matchCount = strlen($match[0]);
			$lineCount = preg_match("/\n.*/", $match[0], $lines);

			$this->yy->lineNo += $lineCount;
			$this->yy->loc->firstLine = $this->yy->loc->lastLine;
			$this->yy->loc->lastLine = $this->yy->lineNo + 1;
			$this->yy->loc->firstColumn = $this->yy->loc->lastColumn;
			$this->yy->loc->lastColumn = $lines ? count($lines[$lineCount - 1]) - 1 : $this->yy->loc->lastColumn + $matchCount;

			$this->yy->text .= $match[0];
			$this->match .= $match[0];
			$this->matches = $match;
			$this->matched .= $match[0];

			$this->yy->leng = strlen($this->yy->text);
			if (isset($this->ranges)) {
				$this->yy->loc->range = new Jison_ParserRange($this->offset, $this->offset += $this->yy->leng);
			}
			$this->more = false;
			$this->input = substr($this->input, $matchCount, strlen($this->input));
			$ruleIndex = $this->rules[$index];
			$nextCondition = $this->conditionsStack[$this->conditionStackCount - 1];

			$token = $this->lexerPerformAction($ruleIndex, $nextCondition);

			if ($this->done == true && empty($this->input) == false) {
				$this->done = false;
			}

			if (empty($token) == false) {
				return $token;
			} else {
				return null;
			}
		}

		if (empty($this->input)) {
			return $this->eof;
		} else {
			$this->lexerError("Lexical error on line " . ($this->yy->lineNo + 1) . ". Unrecognized text.\n" . $this->showPosition(), new Jison_LexerError("", -1, $this->yy->lineNo));
			return null;
		}
	}

	function lexerLex()
	{
		$r = $this->next();

		while (empty($r) && $this->done == false) {
			$r = $this->next();
		}

		return $r;
	}

	function begin($condition)
	{
		$this->conditionStackCount++;
		$this->conditionStack[] = $condition;
	}

	function popState()
	{
		$this->conditionStackCount--;
		return array_pop($this->conditionStack);
	}

	function currentRules()
	{
		$peek = $this->conditionStack[$this->conditionStackCount];
		return $this->conditions[$peek]->rules;
	}

	function lexerPerformAction(&$yy, $yy_, $avoiding_name_collisions, $YY_START = null) {}
}

class Jison_ParserLocation
{
	public $firstLine = 1;
	public $lastLine = 0;
	public $firstColumn = 1;
	public $lastColumn = 0;
	public $range;

	public function __construct($firstLine = 1, $lastLine = 0, $firstColumn = 1, $lastColumn = 0)
	{
		$this->firstLine = $firstLine;
		$this->lastLine = $lastLine;
		$this->firstColumn = $firstColumn;
		$this->lastColumn = $lastColumn;
	}

	public function Range($range)
	{
		$this->range = $range;
	}
}

class Jison_ParserValue
{
	public $leng = 0;
	public $loc;
	public $lineNo = 0;
	public $value;
	public $text;
}

class Jison_LexerConditions
{
	public $rules;
	public $inclusive;

	function __construct($rules, $inclusive)
	{
		$this->rules = $rules;
		$this->inclusive = $inclusive;
	}
}

class Jison_ParserProduction
{
	public $len = 0;
	public $symbol;

	public function __construct($symbol, $len = 0)
	{
		$this->symbol = $symbol;
		$this->len = $len;
	}
}

class Jison_ParserCachedAction
{
	public $action;
	public $symbol;

	function __construct($action, $symbol)
	{
		$this->action = $action;
		$this->symbol = $symbol;
	}
}

class Jison_ParserAction
{
	public $action;
	public $state;

	function __construct($action, $state = null)
	{
		$this->action = $action;
		$this->state = $state;
	}
}

class Jison_ParserSymbol
{
	public $name;
	public $index = -1;
	public $symbols = array();
	public $symbolsByName = array();

	function __construct($name, $index)
	{
		$this->name = $name;
		$this->index = $index;
	}

	public function addAction($a)
	{
		$this->symbols[$a->index] = $this->symbolsByName[$a->name] = $a;
	}
}

class Jison_ParserError
{
	public $text;
	public $state;
	public $symbol;
	public $lineNo;
	public $loc;
	public $expected;

	function __construct($text, $state, $symbol, $lineNo, $loc, $expected)
	{
		$this->text = $text;
		$this->state = $state;
		$this->symbol = $symbol;
		$this->lineNo = $lineNo;
		$this->loc = $loc;
		$this->expected = $expected;
	}
}

class Jison_LexerError
{
	public $text;
	public $token;
	public $lineNo;

	public function lexerError($text, $token, $lineNo)
	{
		$this->text = $text;
		$this->token = $token;
		$this->lineNo = $lineNo;
	}
}

class Jison_ParserState
{
	public $index;
	public $actions = array();

	function __construct($index)
	{
		$this->index = $index;
	}

	public function setActions($actions)
	{
		$this->actions = $actions;
	}
}

class Jison_ParserRange
{
	public $x;
	public $y;

	function __construct($x, $y)
	{
		$this->x = $x;
		$this->y = $y;
	}
}

class Jison_ParserSymbols
{
	private $symbolsString = array();
	private $symbolsInt = array();

	public function add(&$symbol)
	{
		$this->symbolsInt[$symbol->index] = $this->symbolsString[$symbol->name] = $symbol;
	}
}