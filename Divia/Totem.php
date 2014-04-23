<?php
/**
 * Copyright (c) 2014 Aurélien RICHAUD
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * Created 23/04/14 11:39 by Aurélien RICHAUD
 */

namespace Divia;
use Divia\Exception\ApiException;
use Divia\Totem\Ligne;
use Httpful\Request;
use Httpful\Response;
use SimpleXMLElement;

/**
 * Class Totem
 * @package Divia
 */
class Totem {
    /**
     * URL of the totem XML endpoint
     */
    const URL = 'http://timeo3.keolis.com/relais/217.php';

    /**
     * @param array $params
     * @throws Exception\ApiException
     * @return Response
     */
    public static function query($params) {
        /** @var $response Response */
        $response = Request::get(self::URL . '?' . http_build_query($params))
            ->expectsXml()
            ->send();

        // Check for errors
        if ($response->body->erreur instanceof SimpleXMLElement) {
            $code = ''.$response->body->erreur->attributes()->code;
            if ($code != '000') {
                throw new ApiException($code, ''.$response->body->erreur);
            }
        }

        // Everything went smooth, we have a response !
        return $response;
    }


    /**
     * List of lines
     * @return Ligne[]
     */
    public static function listerLignes() {
        $response = Totem::query(array('xml' => 1));

        $ret = array();

        if ($response->body instanceof SimpleXMLElement) {
            /** @var $alss SimpleXMLElement */
            $alss = $response->body->alss;

            /** @var $als SimpleXMLElement */
            foreach($alss->children() as $als) {
                $ret[] = Ligne::fromXml($als);
            }
        }

        return $ret;
    }
} 