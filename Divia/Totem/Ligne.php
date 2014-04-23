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
 * Created 23/04/14 11:45 by Aurélien RICHAUD
 */

namespace Divia\Totem;
use Divia\Totem;
use Httpful\Response;
use SimpleXMLElement;

/**
 * Une ligne de tram / bus
 * @package Divia\Totem
 */
class Ligne {
    public $code;

    public $nom;

    public $sens;

    public $vers;

    public $couleur;

    /**
     * @param SimpleXMLElement $element
     * @return Ligne
     */
    public static function fromXml($element) {
        $ret = new Ligne();
        $ret->code = ''.$element->ligne->code;
        $ret->nom = ''.$element->ligne->nom;
        $ret->sens = ''.$element->ligne->sens;
        $ret->vers = ''.$element->ligne->vers;
        $ret->couleur = dechex(''.$element->ligne->couleur);

        return $ret;
    }

    /**
     * List of all Arrets on this Ligne
     * @return Arret[]
     */
    public function listerArrets() {
        $response = Totem::query(array('xml' => 1, 'ligne' => $this->code, 'sens' => $this->sens));
        $ret = array();

        if ($response->body instanceof SimpleXMLElement) {
            /** @var $alss SimpleXMLElement */
            $alss = $response->body->alss;

            /** @var $als SimpleXMLElement */
            foreach($alss->children() as $als) {
                $ret[] = Arret::fromXml($this, $als);
            }
        }

        return $ret;
    }
} 