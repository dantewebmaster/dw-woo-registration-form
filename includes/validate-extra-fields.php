<?php
/**
 * Valida CNPJ
 *
 * @author Luiz Otávio Miranda <contato@todoespacoonline.com/w>
 * @param string $cnpj 
 * @return bool true para CNPJ correto
 *
 */
function valida_cnpj ( $cnpj ) {
    // Deixa o CNPJ com apenas números
    $cnpj = preg_replace( '/[^0-9]/', '', $cnpj );
    
    // Garante que o CNPJ é uma string
    $cnpj = (string)$cnpj;
    
    // O valor original
    $cnpj_original = $cnpj;
    
    // Captura os primeiros 12 números do CNPJ
    $primeiros_numeros_cnpj = substr( $cnpj, 0, 12 );
    
    /**
     * Multiplicação do CNPJ
     *
     * @param string $cnpj Os digitos do CNPJ
     * @param int $posicoes A posição que vai iniciar a regressão
     * @return int O
     *
     */
    if ( ! function_exists('multiplica_cnpj') ) {
        function multiplica_cnpj( $cnpj, $posicao = 5 ) {
            // Variável para o cálculo
            $calculo = 0;
            
            // Laço para percorrer os item do cnpj
            for ( $i = 0; $i < strlen( $cnpj ); $i++ ) {
                // Cálculo mais posição do CNPJ * a posição
                $calculo = $calculo + ( $cnpj[$i] * $posicao );
                
                // Decrementa a posição a cada volta do laço
                $posicao--;
                
                // Se a posição for menor que 2, ela se torna 9
                if ( $posicao < 2 ) {
                    $posicao = 9;
                }
            }
            // Retorna o cálculo
            return $calculo;
        }
    }
    
    // Faz o primeiro cálculo
    $primeiro_calculo = multiplica_cnpj( $primeiros_numeros_cnpj );
    
    // Se o resto da divisão entre o primeiro cálculo e 11 for menor que 2, o primeiro
    // Dígito é zero (0), caso contrário é 11 - o resto da divisão entre o cálculo e 11
    $primeiro_digito = ( $primeiro_calculo % 11 ) < 2 ? 0 :  11 - ( $primeiro_calculo % 11 );
    
    // Concatena o primeiro dígito nos 12 primeiros números do CNPJ
    // Agora temos 13 números aqui
    $primeiros_numeros_cnpj .= $primeiro_digito;
 
    // O segundo cálculo é a mesma coisa do primeiro, porém, começa na posição 6
    $segundo_calculo = multiplica_cnpj( $primeiros_numeros_cnpj, 6 );
    $segundo_digito = ( $segundo_calculo % 11 ) < 2 ? 0 :  11 - ( $segundo_calculo % 11 );
    
    // Concatena o segundo dígito ao CNPJ
    $cnpj = $primeiros_numeros_cnpj . $segundo_digito;
    
    // Verifica se o CNPJ gerado é idêntico ao enviado
    if ( $cnpj === $cnpj_original ) {
        return true;
    }
}

/**
 * Validate the extra registered fields.
 *
 * @param WP_Error $validation_errors Errors.
 * @param string $username Current username.
 * @param string $email Current email.
 *
 * @return WP_Error
 */
function dw_validate_extra_register_fields ( $errors, $username, $email ) {
    if ( isset( $_POST['billing_first_name'] ) && empty( $_POST['billing_first_name'] ) ) {
        $errors->add( 'billing_first_name_error', '<strong>Erro</strong>: Nome é obrigatório!' );
    }
    
    if ( isset( $_POST['billing_last_name'] ) && empty( $_POST['billing_last_name'] ) ) {
        $errors->add( 'billing_last_name_error', '<strong>Erro</strong>: Sobrenome é obrigatório!' );
    }
    
    if ( isset( $_POST['billing_company'] ) && empty( $_POST['billing_company'] ) ) {
        $errors->add( 'billing_company_error', '<strong>Erro</strong>: Empresa é obrigatório!' );
    }
	
	// validate CNPJ
	if ( isset( $_POST['billing_cnpj'] ) && empty( $_POST['billing_cnpj'] ) ) {
        $errors->add( 'billing_cnpj_error', '<strong>Erro</strong>: CNPJ é obrigatório!' );
    }
	if ( isset( $_POST['billing_cnpj'] ) ) {
		if ( ! valida_cnpj( $_POST['billing_cnpj'] ) || $_POST['billing_cnpj'] == 0 ) {
			$errors->add( 'billing_cnpj_error', '<strong>Erro</strong>: CNPJ inválido!' );			
		}
    }
	
	if ( isset( $_POST['billing_postcode'] ) && empty( $_POST['billing_postcode'] ) ) {
        $errors->add( 'billing_postcode_error', '<strong>Erro</strong>: CEP é obrigatório!' );
    }
	
	if ( isset( $_POST['billing_address_1'] ) && empty( $_POST['billing_address_1'] ) ) {
        $errors->add( 'billing_address_1_error', '<strong>Erro</strong>: Endereço é obrigatório!' );
    }
	
	if ( isset( $_POST['billing_number'] ) && empty( $_POST['billing_number'] ) ) {
        $errors->add( 'billing_number_error', '<strong>Erro</strong>: Endereço é obrigatório!' );
    }
    
	if ( isset( $_POST['billing_neighborhood'] ) && empty( $_POST['billing_neighborhood'] ) ) {
        $errors->add( 'billing_neighborhood_error', '<strong>Erro</strong>: Bairro é obrigatório!' );
    }
    
	if ( isset( $_POST['billing_city'] ) && empty( $_POST['billing_city'] ) ) {
        $errors->add( 'billing_city_error', '<strong>Erro</strong>: Cidade é obrigatório!' );
    }
    
	if ( isset( $_POST['billing_state'] ) && empty( $_POST['billing_state'] ) ) {
        $errors->add( 'billing_state_error', '<strong>Erro</strong>: Estado é obrigatório!' );
    }

    if ( isset( $_POST['billing_phone'] ) && empty( $_POST['billing_phone'] ) ) {
        $errors->add( 'billing_phone_error', '<strong>Erro</strong>: Telefone é obrigatório!' );
    }

    return $errors;
}
add_filter( 'woocommerce_registration_errors', 'dw_validate_extra_register_fields', 10, 3 );
