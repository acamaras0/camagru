<?php

    function number_check($str)
    {
        $i = 0;
        while($str[$i])
        {
            if(is_numeric($str[$i]) == 1)
                return 1;
            $i++;
        }
        return 0;
    }

    function character_check($user)
    {
        if(preg_match('/[\'^£$%&*()}{@#~?!><>\s+,\/|=+¬-]/', $user))
            return 1;
        return 0;
    }
?>