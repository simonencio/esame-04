<?php

namespace Tests\Unit\v1;

use App\Helpers\AppHelpers;
use PHPUnit\Framework\TestCase;

class AppHelpersTest extends TestCase
{
    /** @test */
    public function aggiornaRegoleHelperTest(): void
    {
        $arrStore = [
            "campo1" => 'required|integer',
            "campo2" => 'integer|nullable',
            "campo3" => 'string|max:45|nullable',
            "campo4" => 'required|string|max:45',
            "campo5" => 'integer|min:0|max:2|nullable',
            "campo6" => 'array|nullable',
            "campo7" => 'required|string|max:20|nullable',
        ];
        $arrUpdate = [
            "campo1" => 'integer',
            "campo2" => 'integer|nullable',
            "campo3" => 'string|max:45|nullable',
            "campo4" => 'string|max:45',
            "campo5" => 'integer|min:0|max:2|nullable',
            "campo6" => 'array|nullable',
            "campo7" => 'string|max:20|nullable',
        ];
        $arrTrasformato = AppHelpers::aggiornaRegoleHelper($arrStore);
        $this->assertEquals($arrUpdate, $arrTrasformato);
    }
}
