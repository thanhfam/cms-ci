<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

// folder
defined('F_FILE')      OR define('F_FILE', 'file/');
defined('F_FILE_ORIGINAL')      OR define('F_FILE_ORIGINAL', 'ori/');
defined('F_FILE_OPTIMIZED')      OR define('F_FILE_OPTIMIZED', 'opt/');
defined('F_FILE_THUMB')      OR define('F_FILE_THUMB', 'tmb/');
defined('F_CP')      OR define('F_CP', 'cp/');
defined('F_FRONT')      OR define('F_FRONT', 'front/');
defined('F_PUB')      OR define('F_PUB', 'pub/');

defined('SECRET_KEY')      OR define('SECRET_KEY', '73da72cc2c67aa9cca56dd7946ca2872');

// content type
defined('CT_POST')      OR define('CT_POST', 'post');
defined('CT_CATEGORY')      OR define('CT_CATEGORY', 'category');
defined('CT_COMMENT')      OR define('CT_COMMENT', 'comment');
defined('CT_TF_REPORT')      OR define('CT_TF_REPORT', 'tf_report');

// state type
defined('ST_CONTENT')      OR define('ST_CONTENT', 'content');
defined('ST_APPOINTMENT')      OR define('ST_APPOINTMENT', 'appointment');
defined('ST_USER')      OR define('ST_USER', 'user');

// image type
defined('IT_JPG')      OR define('IT_JPG', 'jpg');
defined('IT_PNG')      OR define('IT_PNG', 'png');

// video type
defined('VT_MP4')      OR define('VT_MP4', 'mp4');
defined('VT_MOV')      OR define('VT_MOV', 'mov');

// media type
defined('MT_IMAGE')      OR define('MT_IMAGE', 'image');
defined('MT_VIDEO')      OR define('MT_VIDEO', 'video');
defined('MT_AUDIO')      OR define('MT_AUDIO', 'audio');
defined('MT_FLASH')      OR define('MT_FLASH', 'flash');
defined('MT_ATTACH')      OR define('MT_ATTACH', 'attach');
defined('MT_IMAGE_EXT')      OR define('MT_IMAGE_EXT', 'jpg|jpeg|gif|png|webp');
defined('MT_VIDEO_EXT')      OR define('MT_VIDEO_EXT', 'mp4|mov|webm');
defined('MT_AUDIO_EXT')      OR define('MT_AUDIO_EXT', 'mp3');
defined('MT_FLASH_EXT')      OR define('MT_FLASH_EXT', 'swf');
defined('MT_ATTACH_EXT')      OR define('MT_ATTACH_EXT', 'docx|doc|xls|xlsx|ppt|pptx|pdf|zip');

// image  direction
defined('ID_HORIZONTAL')      OR define('ID_HORIZONTAL', 'horizontal');
defined('ID_VERTICAL')      OR define('ID_VERTICAL', 'vertical');

// state
defined('S_USER_REMOVED')      OR define('S_USER_REMOVED', -2);
defined('S_REMOVED')      OR define('S_REMOVED', -1);
defined('S_INACTIVATED')      OR define('S_INACTIVATED', 0);
defined('S_ACTIVATED')      OR define('S_ACTIVATED', 9);

// response state
defined('RS_NICE')      OR define('RS_NICE', 0);
defined('RS_DANGER')      OR define('RS_DANGER', -1);
defined('RS_INPUT_DANGER')      OR define('RS_INPUT_DANGER', 1);
defined('RS_AUTH_DANGER')      OR define('RS_AUTH_DANGER', 2);
defined('RS_RIGHT_DANGER')      OR define('RS_RIGHT_DANGER', 3);
defined('RS_DB_DANGER')      OR define('RS_DB_DANGER', 9);

// enum type
defined('ET_CONTACT_GROUP')      OR define('ET_CONTACT_GROUP', 'contact_group');
defined('ET_TVN_SERVICE')      OR define('ET_TVN_SERVICE', 'tvn_service');
defined('ET_PERSON_TITLE')      OR define('ET_PERSON_TITLE', 'person_title');
defined('ET_HOSPITAL')      OR define('ET_HOSPITAL', 'hospital');

// contact type
defined('CONTACT_T_CUSTOMER')      OR define('CONTACT_T_CUSTOMER', 'customer');
defined('CONTACT_T_AGENCY')      OR define('CONTACT_T_AGENCY', 'agency');
defined('CONTACT_T_STAFF')      OR define('CONTACT_T_STAFF', 'staff');
