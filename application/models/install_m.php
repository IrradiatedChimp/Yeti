<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Install_m extends CI_Model {

    public $variable;

    public $groups = 'groups';
    public $users = 'users';
    public $login_attempts = 'login_attempts';

    public function __construct()
    {
        parent::__construct();

    }

    public function editDatabaseConfigFile($find, $replace)
    {
        // Reading and Writing file locations.
        $reading = fopen(APPPATH . 'config/database.php', 'r');
        $writing = fopen(APPPATH . 'config/database.tmp', 'w');

        // Used for holding a true or false for checking if the line has been replaced.
        $replaced = false;

        while (!feof($reading)) {
            $line = fgets($reading);

            if (stristr($line, $find)) {
                $line = $replace;
                $replaced = true;
            }
            fputs($writing, $line);
        }

        fclose($reading);
        fclose($writing);

        // Do not overwrite the file if nothing has been changed.
        if ($replaced) {
            rename(APPPATH . 'config/database.tmp', APPPATH . 'config/database.php');
            return true;
        } else {
            unlink(APPPATH . 'config/database.tmp');
            return false;
        }
    }

    public function editMainConfigFile($find, $replace)
    {
        // Reading and Writing file locations.
        $reading = fopen(APPPATH . 'config/config.php', 'r');
        $writing = fopen(APPPATH . 'config/config.tmp', 'w');

        // Used for holding a true or false for checking if the line has been replaced.
        $replaced = false;

        while (!feof($reading)) {
            $line = fgets($reading);

            if (stristr($line, $find)) {
                $line = $replace;
                $replaced = true;
            }
            fputs($writing, $line);
        }

        fclose($reading);
        fclose($writing);

        // Do not overwrite the file if nothing has been changed.
        if ($replaced) {
            rename(APPPATH . 'config/config.tmp', APPPATH . 'config/config.php');
            return true;
        } else {
            unlink(APPPATH . 'config/config.tmp');
            return false;
        }
    }

    public function editForumConfigFile($find, $replace)
    {
        // Reading and Writing file locations.
        $reading = fopen(APPPATH . 'config/forum.php', 'r');
        $writing = fopen(APPPATH . 'config/forum.tmp', 'w');

        // Used for holding a true or false for checking if the line has been replaced.
        $replaced = false;

        while (!feof($reading)) {
            $line = fgets($reading);

            if (stristr($line, $find)) {
                $line = $replace;
                $replaced = true;
            }
            fputs($writing, $line);
        }

        fclose($reading);
        fclose($writing);

        // Do not overwrite the file if nothing has been changed.
        if ($replaced) {
            rename(APPPATH . 'config/forum.tmp', APPPATH . 'config/forum.php');
            return true;
        } else {
            unlink(APPPATH . 'config/forum.tmp');
            return false;
        }
    }

    public function editRoutesConfigFile($find, $replace)
    {
        // Reading and Writing file locations.
        $reading = fopen(APPPATH . 'config/routes.php', 'r');
        $writing = fopen(APPPATH . 'config/routes.tmp', 'w');

        // Used for holding a true or false for checking if the line has been replaced.
        $replaced = false;

        while (!feof($reading)) {
            $line = fgets($reading);

            if (stristr($line, $find)) {
                $line = $replace;
                $replaced = true;
            }
            fputs($writing, $line);
        }

        fclose($reading);
        fclose($writing);

        // Do not overwrite the file if nothing has been changed.
        if ($replaced) {
            rename(APPPATH . 'config/routes.tmp', APPPATH . 'config/routes.php');
            return true;
        } else {
            unlink(APPPATH . 'config/routes.tmp');
            return false;
        }
    }

    public function testDatabaseConnection($hostname, $username, $password)
    {
        $this->load->database();
        $this->load->dbforge();

        // Create the connection.
        $connection = new mysqli($hostname, $username, $password);

        // Check the connection.
        if ($connection->connect_error) {
            return false;
        }
        return true;
    }

    public function createDatabase($database_name)
    {
        $this->load->database();
        $this->load->dbforge();

        // Create the database.
        if ($this->dbforge->create_database($database_name)) {

            $find = "'database' =>";
            $replace = "\t" . "'database' => '" . $database_name . "'," . "\n";

            if ($this->editDatabaseConfigFile($find, $replace) === true) {
                return true;
            }
        }

        return false;
    }

    public function createTables($database_name)
    {

        $groups = 'groups';
        $users = 'users';
        $login_attempts = 'login_attempts';

        $this->load->database();
        $this->load->dbforge();

        $this->config->load('ion_auth', true);
        $tables = $this->config->item('tables', 'ion_auth');
        $joins = $this->config->item('join', 'ion_auth');

        // Table Names
        $this->groups = $tables['groups'];
        $this->users = $tables['users'];
        $this->login_attempts = $tables['login_attempts'];
        $session = 'ci_sessions';
        $discussions = 'discussions';
        $posts = 'posts';
        $categories = 'categories';

        // Join Names
        $this->groups_join = $joins['groups'];
        $this->users_join = $joins['users'];

        // Groups Table.
        if (!$this->db->table_exists($this->groups)) {

            // Setup Keys
            $this->dbforge->add_key('id', true);

            $this->dbforge->add_field(array(
                'id' => array('type' => 'MEDIUMINT', 'constraint' => 8, 'unsigned' => TRUE, 'null' => FALSE, 'auto_increment' => TRUE),
                'name' => array('type' => 'VARCHAR', 'constraint' => '20', 'null' => FALSE),
                'description' => array('type' => 'VARCHAR', 'constraint' => '100', 'null' => FALSE)
            ));

            // Create the table.
            if (!$this->dbforge->create_table($this->groups, TRUE)) {
                return false;
            } else {
                $this->db->insert($this->groups, array('id' => null, 'name' => 'admin', 'description' => 'Administrator'));
                $this->db->insert($this->groups, array('id' => null, 'name' => 'members', 'description' => 'General User'));
            }
        }

        // Users Table.
        if (!$this->db->table_exists($this->users)) {

            // Setup Keys.
            $this->dbforge->add_key('id', true);

            $this->dbforge->add_field(array(
                'id' => array('type' => 'MEDIUMINT', 'constraint' => 8, 'unsigned' => TRUE, 'null' => FALSE, 'auto_increment' => TRUE),
				'ip_address' => array('type' => 'VARBINARY', 'constraint' => '16', 'null' => FALSE),
				'username' => array('type' => 'VARCHAR', 'constraint' => '100', 'null' => FALSE),
				'password' => array('type' => 'VARCHAR', 'constraint' => '80', 'null' => FALSE),
				'salt' => array('type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE),
				'email' => array('type' => 'VARCHAR', 'constraint' => '100', 'null' => FALSE),
				'activation_code' => array('type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE),
				'forgotten_password_code' => array('type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE),
				'forgotten_password_time' => array('type' => 'int', 'constraint' => '11', 'unsigned' => TRUE, 'null' => TRUE),
				'remember_code' => array('type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE),
				'created_on' => array('type' => 'int', 'constraint' => '11', 'unsigned' => TRUE, 'null' => FALSE),
				'last_login' => array('type' => 'int', 'constraint' => '11', 'unsigned' => TRUE, 'null' => TRUE),
				'active' => array('type' => 'tinyint', 'constraint' => '1', 'unsigned' => TRUE, 'null' => TRUE),
				'first_name' => array('type' => 'VARCHAR', 'constraint' => '50', 'null' => TRUE),
				'last_name' => array('type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE),
				'company' => array('type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE),
				'phone' => array('type' => 'VARCHAR', 'constraint' => '50', 'null' => TRUE)
            ));

            // Create the table.
            if (!$this->dbforge->create_table($this->users, true)) {
                return false;
            }
        }

        // users_groups table.
		if (!$this->db->table_exists("{$this->users}_{$this->groups}"))
		{

            // Setup Keys.
            $this->dbforge->add_key('id', TRUE);

            $this->dbforge->add_field(array(
                'id' => array('type' => 'MEDIUMINT', 'constraint' => 8, 'unsigned' => TRUE, 'null' => FALSE, 'auto_increment' => TRUE),
                "$this->users_join" => array('type' => 'MEDIUMINT', 'constraint' => 8, 'unsigned' => TRUE, 'null' => FALSE),
                "$this->groups_join" => array('type' => 'MEDIUMINT', 'constraint' => 8, 'unsigned' => TRUE, 'null' => FALSE)
            ));

            // Create the table.
            if (!$this->dbforge->create_table("{$this->users}_{$this->groups}", true)) {
                return false;
            } else {
                // define default data
                $data = array(
                    array(
                        "$this->users_join"  => 1,
                        "$this->groups_join" => 1
                    ),
                    array(
                        "$this->users_join"  => 1,
                        "$this->groups_join" => 2
                    )
                );

                // Insert data
                $this->db->insert_batch("{$this->users}_{$this->groups}", $data);
            }
        }

        // login attempts table.
		if (!$this->db->table_exists($this->login_attempts)) {

            // Setup Keys
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->add_key('ip_address');
            $this->dbforge->add_key('login');

            $this->dbforge->add_field(array(
                'id' => array('type' => 'MEDIUMINT', 'constraint' => 8, 'unsigned' => TRUE, 'null' => FALSE, 'auto_increment' => TRUE),
                'ip_address' => array('type' => 'VARBINARY', 'constraint' => '16', 'null' => FALSE),
                'login' => array('type' => 'VARCHAR', 'constraint' => '100', 'null' => FALSE),
                'time' => array('type' => 'int', 'constraint' => '11', 'unsigned' => TRUE, 'null' => FALSE)
            ));

            // Create the table.
            if (!$this->dbforge->create_table($this->login_attempts, true)) {
                return false;
            }
        }

        // Create the sessions table.
        if (!$this->db->table_exists($session)) {

            // Setup keys.
            $this->dbforge->add_key('id', true);
            $this->dbforge->add_key('ci_sessions_timestamp');

            $this->dbforge->add_field(array(
                'id' => array('type' => 'varchar', 'constraint' => '40', 'null' => false),
                'ip_address' => array('type' => 'varchar', 'constraint' => '40', 'null' => false),
                'timestamp' => array('type' => 'int', 'constraint' => '10', 'unsigned' => true, 'null' => false, 'default' => '0'),
                'data' => array('type' => 'blob', 'null' => false)
            ));

            // Create the table.
            if (!$this->dbforge->create_table($session, true)) {
                return false;
            }
        }

        // Create the discussions table.
        if (!$this->db->table_exists($discussions)) {

            // Setup Keys.
            $this->dbforge->add_key('id', true);

            $this->dbforge->add_field(array(
                'id' => array('type' => 'int', 'constraint' => '11', 'unsigned' => true, 'null' => false, 'auto_increment' => true),
                'title' => array('type' => 'varchar', 'constraint' => '255', 'null' => false, 'default' => ''),
                'slug' => array('type' => 'varchar', 'constraint' => '255', 'null' => false, 'default' => ''),
                'category_id' => array('type' => 'int', 'constraint', '11', 'null' => false),
                'created_at' => array('type' => 'datetime', 'null' => false),
                'updated_at' => array('type' => 'datetime', 'default' => null),
                'user_id' => array('type' => 'int', 'constraint' => '11', 'null' => false),
                'is_sticky' => array('type' => 'tinyint', 'constraint' => '4', 'default' => '0'),
                'is_closed' => array('type' => 'tinyint', 'constraint' => '4', 'default' => '0')
            ));

            // Create the table.
            if (!$this->dbforge->create_table($discussions, true)) {
                return false;
            }
        }

        // Create the posts table.
        if (!$this->db->table_exists($posts)) {

            // Setup Keys.
            $this->dbforge->add_key('id', true);

            $this->dbforge->add_field(array(
                'id' => array('type' => 'int', 'constraint' => '11', 'unsigned' => true, 'null' => false, 'auto_increment' => true),
                'content' => array('type' => 'longtext', 'null' => false),
                'user_id' => array('type' => 'int', 'constraint' => '11', 'unsigned' => true, 'null' => false),
                'discussion_id' => array('type' => 'int', 'constraint' => '11', 'null' => false),
                'created_at' => array('type' => 'datetime', 'null' => false),
                'updated_at' => array('type' => 'datetime', 'default' => null),
                'thumbs' => array('type' => 'int', 'constraint' => 11)
            ));

            // Create the table.
            if (!$this->dbforge->create_table($posts, true)) {
                return false;
            }
        }

        // Create the categories table.
        if (!$this->db->table_exists($categories)) {

            // Setup Keys.
            $this->dbforge->add_key('id', true);

            $this->dbforge->add_field(array(
                'id' => array('type' => 'int', 'constraint' => '11', 'unsigned' => true, 'null' => false, 'auto_increment' => true),
                'name' => array('type' => 'varchar', 'constraint' => '255', 'null' => false, 'default' => null),
                'slug' => array('type' => 'varchar', 'constraint' => '255', 'null' => false, 'default' => null),
                'description' => array('type' => 'varchar', 'constraint' => '255', 'null' => false),
                'class' => array('type' => 'varchar', 'constraint' => '255', 'null' => false)
            ));

            // Create the tble.
            if (!$this->dbforge->create_table($categories, true)) {
                return false;
            }
        }

        // if everything is ok, return true
        return true;
    }

    public function deleteInstallationFiles()
    {
        $installation_items = array(
            APPPATH . 'controllers/Install.php',
            APPPATH . 'views/install',
            APPPATH . 'models/Install_m.php',
            APPPATH . 'language/english/install_lang.php',
            APPPATH . 'views/layouts/install.php'
        );

        foreach ($installation_items as $installation_item) {
            $this->deleteFiles($installation_item);
        }

        return true;
    }

    private function deleteFiles($target)
    {
        if (is_dir($target)) {
			$files = glob($target . '*', GLOB_MARK); //GLOB_MARK adds a slash to directories returned
			foreach($files as $file) {
				$this->deleteFiles($file);
			}
			if(file_exists($target) && is_dir($target)) {
				rmdir($target);
			}
		} elseif (is_file($target)) {
			unlink( $target );
		}
    }

}

/* End of file Install_m.php */
/* Location: ./application/models/Install_m.php */
