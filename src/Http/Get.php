<?php
/**
 * Frametek Framework (https://github.com/tekreme73/Frametek)
 *
 * @link		https://github.com/tekreme73/Frametek
 * @copyright	Copyright (c) 2015 Rémi Rebillard
 * @license		https://github.com/tekreme73/Frametek/blob/master/LICENSE (MIT License)
 */
namespace Frametek\Http;

use Frametek\Collections\DataCollection;
use Frametek\Exception\Http\UndefinedHttpException;

/**
 * Get
 *
 * This class
 *
 * @package Frametek
 * @author Rémi Rebillard
 */
class Get extends DataCollection
{

    /**
     *
     * @throws UndefinedHttpException
     */
    public function __construct()
    {
        parent::__construct();
        if (! isset($_GET)) {
            throw new UndefinedHttpException("GET");
        } else {
            $this->setAll($_GET);
        }
    }
}
