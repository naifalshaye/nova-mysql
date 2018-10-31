<template>
    <div>
        <card class="flex flex-col items-center justify-center" style="min-height: 300px">
            <div align="center">
                <img src="https://www.mysql.com/common/logos/logo-mysql-170x115.png">
            </div>
            <hr style="margin-top:10px; margin-bottom: 10px;">

            <div style="margin-top: 20px; width: 500px;">
                <div style="color:#5D8BB9; font-size:18px; font-weight: bold; margin-bottom:10px;">Create New Database </div>
                <label class="inline-block" for="database_name">
                    <span style="color:#5D8BB9; font-size:16px; font-weight: bold;">New Database:</span>
                    <input v-model="database_name" type="text" id="database_name" class="w-full form-control form-input form-input-bordered">
                </label>
                <br><br>
                <button class="ml-auto btn btn-default btn-primary mr-3" @click="createDatabase()">Create Database</button>
            </div>


            <div align="left" style="margin-bottom: 20px; margin-top: 30px;">
                <div style="color:#5D8BB9; font-size:18px; font-weight: bold; margin-bottom:10px; text-align: left;">Current Databases</div>

                <table class="table" >
                    <tr>
                        <td style="height: 45px; font-size:14px; color:#5D8BB9; text-align: left; font-weight: bold; width: 20px !important;">Database</td>
                        <td style="height: 45px; font-size:14px; color:#5D8BB9; text-align: center; font-weight: bold;">Users</td>
                        <td style="height: 45px; font-size:14px; color:#5D8BB9; text-align: center; font-weight: bold; width:40px !important;">Repair</td>
                        <td style="height: 45px; font-size:14px; color:#5D8BB9; text-align: center; font-weight: bold; width:40px !important;">Delete</td>
                    </tr>
                    <tr v-for="database in this.databases">
                        <td style="height:45px; text-align: left;  width: 20px !important;">{{database.db}}</td>
                        <td style="text-align: center;">
                            <ul style="list-style: none;">
                                <li v-for="user in database.userlist">
                                    <div>
                                        <span style="font-size:20px; font-weight: bold; color:red; cursor: pointer;" v-on:click="revokeDatabaseUser(database.db, user.user)">x</span>  {{user.user}}
                                    </div>
                                </li>
                            </ul>
                        </td>
                        <td style="height:45px; text-align: center;"><button v-on:click="repairDB(database.db)" style=" color:#5D8BB9 !important; width:40px !important;">Repair</button></td>
                        <td style="height:45px; text-align: center;"><button v-on:click="deleteDB(database.db)" style=" color:#5D8BB9 !important; width:40px !important;">Delete</button></td>
                    </tr>
                </table>
            </div>

            <hr>

            <div style="margin-top:20px; margin-left:-60px; width:440px;">
                <div style="color:#5D8BB9; font-size:18px; font-weight: bold; margin-bottom:10px;">MySQL Users</div>
                <label class="inline-block" for="username">
                    <span style="color:#5D8BB9; font-size:16px; font-weight: bold;">Username:</span>
                    <input v-model="username" type="text" id="username" class="w-full form-control form-input form-input-bordered">
                </label>
                <br><br>
                <label class="inline-block" for="password">
                    <span style="color:#5D8BB9; font-size:16px; font-weight: bold;">Password:</span>
                    <input v-model="password" type="text" id="password" class="w-full form-control form-input form-input-bordered">
                </label>
                <br><br>
                <button class="ml-auto btn btn-default btn-primary mr-3" @click="addUser()">Create User</button>
            </div>

            <div align="left" style="margin-bottom: 10px; margin-top: 30px;">
                <div style="color:#5D8BB9; font-size:18px; font-weight: bold; margin-bottom:10px; text-align: left;">Current Users</div>

                <table class="table" width="500">
                    <tr>
                        <td style="height: 45px; font-size:14px; color:#5D8BB9; text-align: left; font-weight: bold;">User</td>
                        <td style="height: 45px; font-size:14px; color:#5D8BB9; text-align: center; font-weight: bold;">Change Password</td>
                        <td style="height: 45px; font-size:14px; color:#5D8BB9; text-align: center; font-weight: bold;">Delete</td>
                    </tr>
                    <tr v-for="dbuser in this.dbusers">
                        <td style="height:45px; text-align: left;">{{dbuser.user}}</td>
                        <td style="height:45px; text-align: center;"><button v-on:click="changePassword(dbuser.user)" style=" color:#5D8BB9 !important;">Change Password</button></td>
                        <td style="height:45px; text-align: center;"><button v-on:click="deleteUser(dbuser.user)" style=" color:#5D8BB9 !important;">Delete</button></td>
                    </tr>
                </table>
            </div>

            <hr style="margin-top:20px; margin-bottom: 10px;">

            <div style="margin-top:20px; margin-bottom: 30px; margin-left:-60px; width:430px;">
                <div style="color:#5D8BB9; font-size:18px; font-weight: bold; margin-bottom:10px;">Add User To Database</div>
                <label class="inline-block" for="addto_user">
                    <span style="color:#5D8BB9; font-size:16px; font-weight: bold;">User:</span><br>
                    <select v-model="addto_user" id="addto_user" class="w-full form-control form-input form-input-bordered" style="width:220px;">
                        <option value="" v-for="dbuser in this.dbusers">{{dbuser.user}}</option>
                    </select>

                </label>
                <br><br>
                <label class="inline-block" for="addto_database">
                    <span style="color:#5D8BB9; font-size:16px; font-weight: bold;">Database:</span><br>
                    <select v-model="addto_database" id="addto_database" class="w-full form-control form-input form-input-bordered" style="width:220px;">
                        <option value="" v-for="database in this.databases">{{database.db}}</option>
                    </select>
                </label>
                <br><br>
                <button class="ml-auto btn btn-default btn-primary mr-3" @click="addtoModal()">Add</button>
            </div>

            <sweet-modal ref="addto_modal">
                <div style="color:#5D8BB9; font-size:18px; font-weight: bold; text-align: left;">Select User Privileges</div>
                <div>
                    <table class="table">
                        <tr>
                            <td align="left"><input type="checkbox" value="ALTER" name="selected_privileges[]" /> ALTER</td>
                            <td align="left"><input type="checkbox" value="ALTER ROUTINE" name="selected_privileges[]" /> ALTER ROUTINE</td>
                        </tr>
                        <tr>
                            <td align="left"><input type="checkbox" value="CREATE" name="selected_privileges[]" /> CREATE</td>
                            <td align="left"><input type="checkbox" value="CREATE ROUTINE" name="selected_privileges[]" /> CREATE ROUTINE</td>
                        </tr>
                        <tr>
                            <td align="left"><input type="checkbox" value="CREATE TEMPORARY TABLES" name="selected_privileges[]" /> CREATE TEMPORARY TABLES</td>
                            <td align="left"><input type="checkbox" value="CREATE VIEW" name="selected_privileges[]" /> CREATE VIEW</td>
                        </tr>
                        <tr>
                            <td align="left"><input type="checkbox" value="DELETE" name="selected_privileges[]" /> DELETE</td>
                            <td align="left"><input type="checkbox" value="DROP" name="selected_privileges[]" /> DROP</td>
                        </tr>
                        <tr>
                            <td align="left"><input type="checkbox" value="EVENT" name="selected_privileges[]" /> EVENT</td>
                            <td align="left"><input type="checkbox" value="EXECUTE" name="selected_privileges[]" /> EXECUTE</td>
                        </tr>
                        <tr>
                            <td align="left"><input type="checkbox" value="INDEX" name="selected_privileges[]" /> INDEX</td>
                            <td align="left"><input type="checkbox" value="INSERT" name="selected_privileges[]" /> INSERT</td>
                        </tr>
                        <tr>
                            <td align="left"><input type="checkbox" value="LOCK TABLES" name="selected_privileges[]" /> LOCK TABLES</td>
                            <td align="left"><input type="checkbox" value="REFERENCES" name="selected_privileges[]" /> REFERENCES</td>
                        </tr>
                        <tr>
                            <td align="left"><input type="checkbox" value="SELECT" name="selected_privileges[]" /> SELECT</td>
                            <td align="left"><input type="checkbox" value="SHOW VIEW" name="selected_privileges[]" /> SHOW VIEW</td>
                        </tr>
                        <tr>
                            <td align="left"><input type="checkbox" value="TRIGGER" name="selected_privileges[]" /> TRIGGER</td>
                            <td align="left"><input type="checkbox" value="UPDATE" name="selected_privileges[]" /> UPDATE</td>
                        </tr>
                    </table>
                    <div align="center" style="margin-top:20px;">
                        <button class="ml-auto btn btn-default btn-primary mr-3" @click="addUserToDB()">Make Changes</button>
                    </div>
                </div>

            </sweet-modal>


            <sweet-modal ref="change_password">
                <div>
                    <div style="color:#5D8BB9; font-size:18px; font-weight: bold; text-align: left;">Set MySQL User Password</div>
                    <div align="left" style="color:#5D8BB9; font-size:16px; font-weight: bold; text-align: left; margin-top:20px;">Username:</div>
                    <div align="left">{{this.username}}</div>

                    <div align="left" style="margin-top:20px; margin-bottom:20px;">
                        <label class="inline-block" for="change_password_pass">
                            <span style="color:#5D8BB9; font-size:16px; font-weight: bold;">Password</span>
                            <input v-model="change_password_pass" type="text" id="change_password_pass" class="w-full form-control form-input form-input-bordered">
                        </label>
                        <br><br>
                        <label class="inline-block" for="change_password_again">
                            <span style="color:#5D8BB9; font-size:16px; font-weight: bold;">Password (Again)</span>
                            <input v-model="change_password_again" type="text" id="change_password_again" class="w-full form-control form-input form-input-bordered">
                        </label>
                    </div>
                    <button class="ml-auto btn btn-default btn-primary mr-3" @click="changePass()">Change Password</button>

                </div>
            </sweet-modal>

            <sweet-modal icon="success" ref="success_modal">
                {{this.success_msg}}
            </sweet-modal>

            <sweet-modal icon="error" ref="error_modal">
                {{this.error_msg}}
            </sweet-modal>

        </card>
    </div>
</template>

<script>
    import { SweetModal, SweetModalTab } from 'sweet-modal-vue'

    export default {

        components: {
            SweetModal,
            SweetModalTab,
        },

        data() {
            return {
                databases: [],
                dbusers: [],
                success_msg: '',
                error_msg: '',
                username: '',
            }
        },
        mounted() {
            this.init();

        },
        methods: {
            init(){
                //get databases
                Nova.request().get('/nova-vendor/nova-mysql/get_databases')
                    .then(response => {
                    this.databases = response.data.databases;
            })
            .catch(response => {
                    this.error('Failed to get databases')
            });

                //get users
                Nova.request().get('/nova-vendor/nova-mysql/get_users')
                    .then(response => {
                    this.dbusers = response.data.dbusers;
            })
            .catch(response => {
                    this.error('Failed to get users')
            });

            },
            createDatabase(){
                var db_name = document.getElementById('database_name').value;
                Nova.request().post('/nova-vendor/nova-mysql/create_database', {
                    name: db_name
                }).then(response => {
                    if (response.data.error){
                    this.error(response.data.error)
                } else{
                    this.success(response.data.success);
                    this.init();
                }
            })
            .catch(response => {
                    this.error('Failed to create database');
            });
            },
            deleteDB(database){
                if (confirm("Are you sure you want to delete this database? All data will be wiped!")){
                    Nova.request().post('/nova-vendor/nova-mysql/delete_database', {
                        name: database
                    }).then(response => {
                        if (response.data.error){
                        this.error(response.data.error)
                    } else{
                        this.success(response.data.success);
                        this.init();
                    }
                })
                .catch(response => {
                        this.error('Failed to delete database');
                });
                }
            },
            repairDB(database){
                if (confirm("Are you sure you want to repair this database?")){
                    Nova.request().post('/nova-vendor/nova-mysql/repair_database', {
                        name: database
                    }).then(response => {
                        if (response.data.error){
                        this.error(response.data.error)
                    } else{
                        this.success(response.data.success);
                        this.init();
                    }
                })
                .catch(response => {
                        this.error('Failed to delete database');
                });
                }
            },
            addUser(){
                var username = document.getElementById('username').value;
                var password = document.getElementById('password').value;
                Nova.request().post('/nova-vendor/nova-mysql/add_user', {
                    username: username,
                    password: password,
                }).then(response => {
                    if (response.data.error){
                    this.error(response.data.error)
                } else{
                    this.success(response.data.success);
                    this.init();
                }
            })
            .catch(response => {
                    this.error('Failed to create user')

            });
            },
            deleteUser(username){
                if (confirm("Are you sure you want to delete this user?")){
                    Nova.request().post('/nova-vendor/nova-mysql/delete_user', {
                        username: username
                    }).then(response => {
                        if (response.data.error){
                        this.error(response.data.error)
                    } else{
                        this.success(response.data.success);
                        this.init();
                    }
                })
                .catch(response => {
                        this.error('Failed to create user')

                });
                }
            },
            addUserToDB(){
                var selected_privileges = [];
                var checkboxes = document.getElementsByName('selected_privileges[]');
                for (var i=0, n=checkboxes.length;i<n;i++) {
                    if (checkboxes[i].checked) {
                        selected_privileges.push(checkboxes[i].value);
                    }
                }
                var addto_user = document.getElementById('addto_user');
                var addto_user = addto_user.options[addto_user.selectedIndex].text;
                var addto_database = document.getElementById('addto_database');
                var addto_database = addto_database.options[addto_database.selectedIndex].text;

                Nova.request().post('/nova-vendor/nova-mysql/add_user_to_database', {
                    user: addto_user,
                    database: addto_database,
                    privileges: selected_privileges,
                }).then(response => {
                    if (response.data.error){
                    this.error(response.data.error)
                } else{
                    this.success(response.data.success);
                    this.init();
                }
            })
            .catch(response => {
                    this.error('Failed to add user to database')
            });
            },
            revokeDatabaseUser(database, user){
                if (confirm("Are you sure you want to revoke access from this user from this database?")){
                    Nova.request().post('/nova-vendor/nova-mysql/revoke_database_user', {
                        user: user,
                        database: database
                    }).then(response => {
                        if (response.data.error){
                        this.error(response.data.error)
                    } else{
                        this.success(response.data.success);
                        this.init();
                    }
                })
                .catch(response => {
                        this.error('Failed to revoke user from this database')

                });
                }
            },
            changePass(){
                var username = this.username;
                var change_password_pass = document.getElementById('change_password_pass').value;
                var change_password_again = document.getElementById('change_password_again').value;
                if (change_password_pass != change_password_again){
                    this.error('Password confirmation does not match!');
                } else{
                    Nova.request().post('/nova-vendor/nova-mysql/change_password', {
                        user: username,
                        password: change_password_pass
                    }).then(response => {
                        if (response.data.error){
                        this.error(response.data.error)
                    } else{
                        this.success(response.data.success);
                        this.init();
                    }
                })
                .catch(response => {
                        this.error('Failed to change password!')

                });
                }
            },
            addtoModal(){
                this.$refs.addto_modal.open('tab1')
            },
            changePassword(user){
                this.username = user;
                this.$refs.change_password.open('tab1');
            },
            success(msg){
                this.success_msg = msg;
                this.$refs.success_modal.open('tab1')
            },
            error(msg){
                this.error_msg = msg;
                this.$refs.error_modal.open('tab1');
            },
        }
    }
</script>

