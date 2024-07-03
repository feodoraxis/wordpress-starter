<?php

namespace Feodoraxis;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Ajax {

    public function __construct() {
        add_action( 'wp_ajax_'        . 'recall_form', array( $this, 'recall_form' ) );
        add_action( 'wp_ajax_nopriv_' . 'recall_form', array( $this, 'recall_form' ) );
    }

    public function recall_form() {

        $this->is_ajax();

        $name = sanitize_text_field( $_POST['name'] );
        $email = sanitize_text_field( $_POST['email'] );
        $phone = sanitize_text_field( $_POST['phone'] );

        $mail_theme = "Сообщение из формы заявок на тест драйв";
        $email_to   = carbon_get_theme_option( "option-email-recall" );

        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        $headers .= "From: boot@" . $_SERVER["HTTP_HOST"] . "\r\n";

        $multipart = create_message(
            $mail_theme,
            [
                "Выбранное место" => $location,
                "Дата брони" => $date,
                "Имя" => $name,
                "E-mail" => $email,
                "Телефон" => $phone,
            ]
        );

        if ( wp_mail( $email_to, $mail_theme, $multipart, $headers )  ) {
            wp_send_json_success( [
                "message" => "success"
            ] )
        }
    
        wp_send_json_error( [
            "message" => "error"
        ] );
    }

    public function is_ajax():void {
        if ( $_SERVER['REQUEST_METHOD'] != 'POST' || ! wp_doing_ajax() ) {
            wp_send_json_error();
        }
    }
}