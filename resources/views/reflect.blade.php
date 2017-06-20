@extends('layouts.dlayout')

@section('content')
    
<div class="container">
    <div class="row">
    
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">

                
                <!--<a href="#" style="color:#fff;"><i class="fa fa-btn fa-clone"></i>New Field</a>-->
                    {{ Auth::user()->name }}, This is the looking back page.
                </div>
 
<!--                <div id="main-message-div" class="panel-body">
                    You are logged in!
                </div>-->
                    
                <div class="panel-body">
                
                    <div class="row">
                        <div class="col-sm-4"><h3>Did what?</h3></div>
                        <div class="col-sm-4"><h3>How long?</h3></div>
                        <div class="col-sm-4"><h3>When?</h3></div>
                    </div>
                
                    <div class="row">
                        <div class="col-sm-4">
                        
                        </div>
                        <div class="col-sm-4">
                            
                        </div>
                        <div class="col-sm-4">
                        
                        </div>
                    </div>

                    <br />
                    
                    <div class="row">
                        <div class="col-sm-4">
                        </div>
                        <div class="col-sm-4">
                        </div>
                        <div class="col-sm-4">
                        </div>
                    </div> 
                        
                    <div id="habits-block" style="display: inline-block;width:50%"></div>
                    
                </div>
                
                    <div id="ajax-box" style="display: inline-block;"></div>
                    <div id="ajax-box2" style="display: inline-block;"></div>
                
            </div>
                <pre></pre>
        </div>
    </div>
</div>
@endsection
