<?php
namespace App\Services\Abstracts\Domain\Facades;

use App\Services\Views\Domain\Services\Elements\ViewElementInterface;
use App\Services\Views\Domain\Services\Elements\ViewNestedElementInterface;
use App\Services\Views\Domain\Services\ViewManagerInterface;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Facade;

/**
 * @method static appendElement(ViewNestedElementInterface|ViewElementInterface $element)
 * @method static bool hasElementByTag(string $tag)
 * @method static Htmlable registerJsFiles(ViewElementInterface $element)
 * @method static Htmlable renderElementByTag(string $tag)
 *
 */
class ViewManager extends Facade {
    protected static function getFacadeAccessor() {
        return ViewManagerInterface::class;
    }
}
