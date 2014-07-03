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
 * Created 23/04/14 12:05 by Aurélien RICHAUD
 */

namespace Divia\Totem;


use Divia\Totem;
use SimpleXMLElement;

class Arret {
    /**
     * @var string
     */
    public $code;

    /**
     * @var string
     */
    public $nom;

    /**
     * @var string
     */
    public $refs;

    /**
     * @var Ligne
     */
    public $ligne;


    /**
     * @param Ligne $ligne
     * @param SimpleXMLElement $element
     * @return \Divia\Totem\Arret
     */
    public static function fromXml($ligne, $element) {
        $ret = new Arret();
        $ret->code = ''.$element->arret->code;
        $ret->nom = ''.$element->arret->nom;
        $ret->refs = ''.$element->refs;
        $ret->ligne = $ligne;

        return $ret;
    }

    /**
     * @return Horaire[]
     */
    public function getHoraires() {
        $response = Totem::query(array('xml' => 3, 'refs' => $this->refs, 'ran' => 1));
        $ret = array();

        if ($response->body instanceof SimpleXMLElement) {
            /** @var $horaires SimpleXMLElement */
            $horaires = $response->body->horaires;

            /** @var $horaire SimpleXMLElement */
            foreach($horaires->children() as $horaire) {
                $ret[] = Horaire::fromXml($this, $horaire);
            }
        }

        return $ret;
    }
} 