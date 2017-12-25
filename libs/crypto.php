<?php 
		
		//MÃ HÓA PHI ĐỐI XỨNG AES
    	//Cau hinh ma hoa 2 chieu
	    // $key_len = uniqid(true);
	    // $key = pack("H*",substr(sha1($key_len).md5($key_len),0,64));
	    // $key = 'LTWEB20171-ibookonline-A';
	    $key = pack("H*","4c5457454232303137312d69626f6f6b6f6e6c696e652d41");

	    # show key size use either 16, 24 or 32 byte keys for AES-128, 192
	    # and 256 respectively
	    $key_size =  strlen($key);
	     
	    # create a random IV to use with CBC encoding - tạo khóa IV tự động sử dụng thuật toán CBC
	    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_192, MCRYPT_MODE_CBC);
	    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);

	    function encryptPassword($plaintext){
	    	GLOBAL $key;
	    	GLOBAL $iv;

	        # creates a cipher text compatible with AES (Rijndael block size = 256)
	        # to keep the text confidential 
	        # only suitable for encoded input that never ends with value 00h
	        # (because of default zero padding)
	        $ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_192, $key,
	                                     $plaintext, MCRYPT_MODE_CBC, $iv);
	     
	        # prepend the IV for it to be available for decryption
	        $ciphertext = $iv. $ciphertext;
	         
	        # encode the resulting cipher text so it can be represented by a string
	        $ciphertext_base64 = base64_encode($ciphertext);    
	        return $ciphertext_base64;
	    }


	    function decryptPassword($ciphertext_base64){
	        
	        GLOBAL $key;
	    	GLOBAL $iv_size;

	        $ciphertext_dec = base64_decode($ciphertext_base64);
	         
	        # retrieves the IV, iv_size should be created using mcrypt_get_iv_size()
	        $iv_dec = substr($ciphertext_dec, 0, $iv_size);
	         
	        # retrieves the cipher text (everything except the $iv_size in the front)
	        $ciphertext_dec = substr($ciphertext_dec, $iv_size);
	     
	        # may remove 00h valued characters from end of plain text
	        $plaintext_dec = mcrypt_decrypt(MCRYPT_RIJNDAEL_192, $key, $ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);
	         
	        return $plaintext_dec;
	    }
?>