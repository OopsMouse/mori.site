<?php

class MailCatherTest extends WP_UnitTestCase
{
	public function setUp()
	{
		parent::setUp();

		global $phpmailer;
		$phpmailer = new PHPMailer();
	}

	/**
	 * @test
	 */
	public function wp_mail()
	{
		wp_mail( "test@example.com", "This is subject", "This is body" );

		$message = $this->get_last_mail();

		$this->assertSame( "<test@example.com>", $message->recipients[0] );
		$this->assertSame( "This is subject", $message->subject );
		$this->assertTrue( !! strpos( $message->source, "This is body" ) );
	}

	private function get_last_mail()
	{
		$messages = json_decode( file_get_contents('http://127.0.0.1:1080/messages' ) );
		$message = end( $messages );
		return json_decode( file_get_contents('http://127.0.0.1:1080/messages/'.$message->id.'.json' ) );
	}
}
