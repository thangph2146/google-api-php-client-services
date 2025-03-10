<?php
/*
 * Copyright 2014 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */

namespace Google\Service\Spanner;

class AdaptMessageRequest extends \Google\Model
{
  /**
   * @var string[]
   */
  public $attachments;
  /**
   * @var string
   */
  public $payload;
  /**
   * @var string
   */
  public $protocol;

  /**
   * @param string[]
   */
  public function setAttachments($attachments)
  {
    $this->attachments = $attachments;
  }
  /**
   * @return string[]
   */
  public function getAttachments()
  {
    return $this->attachments;
  }
  /**
   * @param string
   */
  public function setPayload($payload)
  {
    $this->payload = $payload;
  }
  /**
   * @return string
   */
  public function getPayload()
  {
    return $this->payload;
  }
  /**
   * @param string
   */
  public function setProtocol($protocol)
  {
    $this->protocol = $protocol;
  }
  /**
   * @return string
   */
  public function getProtocol()
  {
    return $this->protocol;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(AdaptMessageRequest::class, 'Google_Service_Spanner_AdaptMessageRequest');
