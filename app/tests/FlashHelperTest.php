<?php
/**
 * Created by PhpStorm.
 * User: Chad
 * Date: 8/25/14
 * Time: 7:27 AM
 */

class FlashHelperTest extends TestCase {

    public function testConvertKeyStringToArray()
    {
        FlashHelper::push('test', 'expectedValue1');
        $this->assertEquals('expectedValue1', Session::get('test')[0]);

        FlashHelper::push('test', 'expectedValue2');
        $this->assertEquals('expectedValue2', Session::get('test')[1]);
    }

} 