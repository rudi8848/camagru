class puphpet::mysql::php
 inherits puphpet::mysql::params {

  include puphpet::php::params

  $mysql = $puphpet::params::hiera['mysql']
  $php   = $puphpet::params::hiera['php']

  if array_true($php, 'install') {
    $php_package = 'php'
  } else {
    $php_package = false
  }

  if $php_package == 'php' {
    $php_module = $::osfamily ? {
      'debian' => 'mysqlnd',
      'redhat' => 'mysql',
    }

    if ! defined(Puphpet::Php::Module::Package[$php_module]) {
      puphpet::php::module::package { $php_module:
        service_autorestart => true,
      }
    }
  }

}
