


    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Register</div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ route('api.register') }}">
                            {{ csrf_field() }}

                            <div >
                                <label for="name" class="col-md-4 control-label">Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" placeholder="请输入名称" required autofocus>


                                </div>
                            </div>

                            <div>
                                <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" placeholder="请输入正确的email" required>


                                </div>
                            </div>

                            <div >
                                <label for="password" class="col-md-4 control-label">Password</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" placeholder="请输入6-10位密码" required>


                                </div>
                            </div>

                            <div class="form-group">
                                <label for="code" class="col-md-4 control-label">推荐码</label>

                                <div class="col-md-6">
                                    <input id="code" type="text" class="form-control" placeholder="非必填" name="code" >
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Register
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


