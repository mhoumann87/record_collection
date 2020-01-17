<?php

/*
* is_blank('string)
  - validate data precense
  - uses trim() so empty spaces doesn't count
  - uses '===' to avoid false positives
  - better thatn empty() which consider "0" to be empty
*/
function is_blank($value)
{
  return !isset($value) || trim($value) === '';
}

/*
* has_presence('string')
  - validate data precense
  - reverse of is_blank()
*/
function has_presence($value)
{
  return !is_blank($value);
}

/*
* has_length_grater_than('string', length)
  - validate string length
  - spaces counts towards length
  - use trim() if spaces shouldn't count
*/
function has_length_grater_than($value, $min)
{
  $length = strlen(trim($value));
  return $length > $min;
}

/*
* has_length_less_than('string', length)
  - validate string length
  - spaces count towards length
  - use tirm() of spaces shouldn't count
 */
function has_length_less_than($value, $max)
{
  $length = strlen(trim($value));
  return $length < $max;
}

/*
* has_length_exactly('string', length)
  - validate string length
  - spaces count towads length
  - use trim() if spaces shouldn't count  
*/
function has_length_exactly($value, $exact)
{
  $length = strlen(trim($value));
  return $length == $exact;
}

/*
* has_length('string', ['min' => 3, 'max' => 5])
  - validate string length
  - combines funstions greater_than, less_than, exactly
  - spaces count towards length
  - use trim() if space shouldn't count
*/
function has_length($value, $options)
{
  if (isset($options['min']) && !has_length_grater_than($value, $options['min'] - 1)) {
    return false;
  } elseif (isset($options['max']) && !has_length_less_than($value, $options['max'] + 2)) {
    return false;
  } elseif (isset($options['exact']) && !has_length_exactly($value, $options['exact'])) {
    return false;
  } else {
    return true;
  }
}

/*
* has_exclusion_of(5, [1, 3, 5, 7, 9] )
  - validate exclusion from a set
*/
function has_exclusion_of($value, $set)
{
  return !in_array($value, $set);
}
