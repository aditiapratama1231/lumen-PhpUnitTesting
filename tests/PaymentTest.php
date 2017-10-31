<?php

use App\Shit;
use App\Payment;

class SomeClass{
    public function ngarti(){
    }
}

class PaymentTest extends TestCase{

    public function testStub(){
        $test = $this->createMock('SomeClass');

        $test->method('ngarti')->willReturn(true);

        // print_r($test);
        $this->assertTrue($test->ngarti());
    }




// class PaymenTest extends TestCase{
    
    public function testProcessPaymentReturnsTrueOnSuccessfulPayment(){
        
        $paymentDetails = array(
            'amount'   => 123.99,
            'card_num' => '4111-1111-1111-1111',
            'exp_date' => '03/2013',
        );

        $payment = new Payment();

        // $authorizeNet = new \AuthorizeNetAIM($payment::API_ID, $payment::TRANS_KEY);
        $response = new \stdClass();
        $response->approved = true;
        $response->transaction_id = 123;
        
        $authorizeNet = $this->getMockBuilder('\AuthorizeNetAIM')
                            ->setConstructorArgs(array($payment::API_ID, $payment::TRANS_KEY))
                            ->getMock();
        
        // var_dump($authorizeNet->authorizeAndCapture());
        
        $authorizeNet->expects($this->once())
                    ->method('authorizeAndCapture')
                    ->will($this->returnValue($response));

        $result = $payment->processPayment($authorizeNet, $paymentDetails);
        
        $this->assertTrue($result);
    }

}