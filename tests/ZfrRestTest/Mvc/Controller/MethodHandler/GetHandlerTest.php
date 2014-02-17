<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */

namespace ZfrRestTest\Mvc\Controller\MethodHandler;

use PHPUnit_Framework_TestCase;
use ZfrRest\Mvc\Controller\MethodHandler\GetHandler;

/**
 * @licence MIT
 * @author  Michaël Gallego <mic.gallego@gmail.com>
 *
 * @group  Coverage
 * @covers \ZfrRest\Mvc\Controller\MethodHandler\GetHandler
 */
class GetHandlerTest extends PHPUnit_Framework_TestCase
{
    public function testThrowMethodNotAllowedIfNoDeleteMethodIsSet()
    {
        $this->setExpectedException('ZfrRest\Http\Exception\Client\MethodNotAllowedException');

        $controller = $this->getMock('ZfrRest\Mvc\Controller\AbstractRestfulController');

        $handler = new GetHandler();
        $handler->handleMethod($controller, $this->getMock('ZfrRest\Resource\ResourceInterface'));
    }

    public function testCanReturnData()
    {
        $controller = $this->getMock('ZfrRest\Mvc\Controller\AbstractRestfulController', ['get']);
        $resource   = $this->getMock('ZfrRest\Resource\ResourceInterface');

        $data = new \stdClass();
        $resource->expects($this->once())
                 ->method('getData')
                 ->will($this->returnValue($data));

        $controller->expects($this->once())
                   ->method('get')
                   ->with($data)
                   ->will($this->returnValue(['foo' => 'bar']));

        $controller->expects($this->never())
                   ->method('getResponse');

        $handler = new GetHandler();
        $result  = $handler->handleMethod($controller, $resource);

        $this->assertEquals(['foo' => 'bar'], $result);
    }
}
