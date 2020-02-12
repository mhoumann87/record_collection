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

/*
* has_string('nobody@nowhere.com', '.com')
  - validate inclusion og character(s)
  - strpos returns string start position or false
  - uses !== to prevent position 0 from being considered false
  - strpos is faster than preg_match()
*/
function has_string($value, $required_string)
{
  return strpos($value, $required_string) !== false;
}

/*
* has_valid_email_format('nobody@mowhere.com')
  - validate correct format for email address
  - format: [chars]@[chars].[2+ letters]
  - preg_match is helpful, uses a regular expression
      returns 1 for a match, 0 for no match
      http://php.net/manual/en/function.preg-match.php
*/
function has_valid_email_format($value)
{
  $email_regex = '/\A[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}\Z/i';
  return preg_match($email_regex, $value) === 1;
}

/*
* has_unique_entries (username and email)
  - Validates uniqueness of entries
  - For new records, provide only column name and value
  - For existing records also provide the id
      has_unique_entries(username, 'testing', 5)
 */
function has_unique_entries($column, $value, $current_id = "0")
{
  $user = User::find_by_column($column, $value);
  if ($user === false || $user->id == $current_id) {
    // input is unique
    return true;
  } else {
    // User already in database
    return false;
  }
}
