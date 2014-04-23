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
 * Created 23/04/14 12:24 by Aurélien RICHAUD
 */

namespace Divia\Totem;


use SimpleXMLElement;

class Horaire {
    /**
     * @var string
     */
    public $code;

    /**
     * @var Arret
     */
    public $arret;

    /**
     * @var Ligne
     */
    public $ligne;

    /**
     * @var Passage[]
     */
    public $passages;

    /**
     * @var Message[]
     */
    public $messages;

    /**
     * @param Arret $arret
     * @param SimpleXMLElement $element
     * @return \Divia\Totem\Horaire
     */
    public static function fromXml($arret, $element) {
        $ret = new Horaire();
        $ret->code = $element->description->code;
        $ret->arret = $arret;
        $ret->ligne = $arret->ligne;

        // Add Passages
        $ret->passages = array();
        foreach($element->passages->children() as $message) {
            $ret->passages[] = Passage::fromXml($message);
        }

        // Add Messages
        $ret->messages = array();
        foreach($element->messages->children() as $message) {
            $ret->messages[] = Message::fromXml($message);
        }

        return $ret;
    }
} 