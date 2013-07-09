node default {
  class { 'owa': }

  class { 'mysql::server': 
     config_hash => { 'root_password' => 'foo' }
  } -> 
  class { 'apache': }
  class { 'apache::mod::php': }

  apache::vhost { 'www':
      priority        => '10',
      vhost_name      => '192.168.33.11',
      port            => '80',
      docroot         => '/opt/owa',
  }
}
