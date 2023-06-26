<?php
class whiteList {
    public function white_list($value, $allowed, $message) {
        if ($value === null) {
            return $allowed[0];
        }
        $key = array_search($value, $allowed, true);
        if ($key === false) {
            throw new InvalidArgumentException($message);
        } else {
            return $value;
        }
    }
}
