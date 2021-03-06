<?php

namespace TailgateApi\Validators;

use Respect\Validation\Validator as V;
use Tailgate\Domain\Model\Season\Season;
use TailgateApi\Validators\Season\SeasonExist;
use Tailgate\Domain\Model\Season\SeasonViewRepositoryInterface;
use Tailgate\Domain\Model\Season\GameViewRepositoryInterface;
use TailgateApi\Validators\Season\GameExist;

class UpdateGameScoreCommandValidator extends AbstractRespectValidator
{
    private $seasonViewRepository;
    private $gameViewRepository;

    public function __construct(
        SeasonViewRepositoryInterface $seasonViewRepository,
        GameViewRepositoryInterface $gameViewRepository
    ) {
        $this->seasonViewRepository = $seasonViewRepository;
        $this->gameViewRepository = $gameViewRepository;
    }

    protected function addRules($command)
    {
        V::with("TailgateApi\Validators\Season\\");

        $this->rules['seasonId'] = V::notEmpty()->SeasonExist($this->seasonViewRepository)->setName('Season');
        $this->rules['gameId'] = V::notEmpty()->GameExist($this->gameViewRepository)->setName('Game');
        $this->rules['homeTeamScore'] = V::optional(V::intVal()->min(0))->setName('Home Team Score');
        $this->rules['awayTeamScore'] = V::optional(V::intVal()->min(0))->setName('Away Team Score');
        $this->rules['startDate'] = V::notEmpty()->date('Y-m-d')->setName('Start Date');
        $this->rules['startTime'] = V::oneOf(V::date('H:i'), V::notEmpty()->stringType()->length(2, 255))->setName('Start Time');
    }
}
