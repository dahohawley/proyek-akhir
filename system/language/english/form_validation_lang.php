<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2016, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2016, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

$lang['form_validation_required']		= '<div class="alert alert-danger">Kolom {field} tidak boleh kosong.</div>';
$lang['form_validation_isset']			= '<div class="alert alert-danger">The {field} field must have a value.</div>';
$lang['form_validation_valid_email']		= '<div class="alert alert-danger">The {field} field must contain a valid email address.</div>';
$lang['form_validation_valid_emails']		= '<div class="alert alert-danger">The {field} field must contain all valid email addresses.</div>';
$lang['form_validation_valid_url']		= '<div class="alert alert-danger">The {field} field must contain a valid URL.</div>';
$lang['form_validation_valid_ip']		= '<div class="alert alert-danger">The {field} field must contain a valid IP.</div>';
$lang['form_validation_min_length']		= '<div class="alert alert-danger">The {field} field must be at least {param} characters in length.</div>';
$lang['form_validation_max_length']		= '<div class="alert alert-danger">The {field} field cannot exceed {param} characters in length.</div>';
$lang['form_validation_exact_length']		= '<div class="alert alert-danger">The {field} field must be exactly {param} characters in length.</div>';
$lang['form_validation_alpha']			= '<div class="alert alert-danger">The {field} field may only contain alphabetical characters.</div>';
$lang['form_validation_alpha_numeric']		= '<div class="alert alert-danger">The {field} field may only contain alpha-numeric characters.</div>';
$lang['form_validation_alpha_numeric_spaces']	= '<div class="alert alert-danger">The {field} field may only contain alpha-numeric characters and spaces.</div>';
$lang['form_validation_alpha_dash']		= '<div class="alert alert-danger">The {field} field may only contain alpha-numeric characters, underscores, and dashes.</div>';
$lang['form_validation_numeric']		= '<div class="alert alert-danger">The {field} field must contain only numbers.</div>';
$lang['form_validation_is_numeric']		= '<div class="alert alert-danger">The {field} field must contain only numeric characters.</div>';
$lang['form_validation_integer']		= '<div class="alert alert-danger">The {field} field must contain an integer.</div>';
$lang['form_validation_regex_match']		= 'The {field} field is not in the correct format.</div>';
$lang['form_validation_matches']		= '<div class="alert alert-danger">The {field} field does not match the {param} field.</div>';
$lang['form_validation_differs']		= '<div class="alert alert-danger">The {field} field must differ from the {param} field.</div>';
$lang['form_validation_is_unique'] 		= '<div class="alert alert-danger">The {field} field must contain a unique value.</div>';
$lang['form_validation_is_natural']		= '<div class="alert alert-danger">The {field} field must only contain digits.</div>';
$lang['form_validation_is_natural_no_zero']	= 'The {field} field must only contain digits and must be greater than zero.</div>';
$lang['form_validation_decimal']		= '<div class="alert alert-danger">The {field} field must contain a decimal number.</div>';
$lang['form_validation_less_than']		= '<div class="alert alert-danger">The {field} field must contain a number less than {param}.</div>';
$lang['form_validation_less_than_equal_to']	= '<div class="alert alert-danger">The {field} field must contain a number less than or equal to {param}.</div>';
$lang['form_validation_greater_than']		= '<div class="alert alert-danger">The {field} field must contain a number greater than {param}.</div>';
$lang['form_validation_greater_than_equal_to']	= '<div class="alert alert-danger">The {field} field must contain a number greater than or equal to {param}.</div>';
$lang['form_validation_error_message_not_set']	= '<div class="alert alert-danger">Unable to access an error message corresponding to your field name {field}.</div>';
$lang['form_validation_in_list']		= '<div class="alert alert-danger">The {field} field must be one of: {param}.</div>';
