<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 animated fadeIn col-lg-6 center-screen">
            <div class="card w-90  p-4">
                <div class="card-body">
                    <h4>SIGN IN</h4>
                    <br/>
                    <input id="email" placeholder="User Email" class="form-control" type="email"/>
                    <br/>
                    <input id="password" placeholder="User Password" class="form-control" type="password"/>
                    <br/>
                    <button onclick="LoginSubmit()" class="btn w-100 bg-gradient-primary">Next</button>
                    <hr/>
                    <div class="float-end mt-3">
                        <span>
                            <a class="text-center ms-3 h6" href="{{url('/userRegistration')}}">Sign Up </a>
                            <span class="ms-1">|</span>
                            <a class="text-center ms-3 h6" href="{{url('/sendOtp')}}">Forget Password</a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- <script>
async function SubmitLogin(){
let email=document.getElementById('email').value;let password=document.getElementById('password').value;
if(email.length === 0 ){  errorToast("Email Required"); }else if(password.length === 0){errorToast('Password Required');  }
else{showLoader();let res=await axios.post("/user-login",{email:email, password:password});
hideLoader()if(res.status===200 && res.data['status']==='success'){window.location.href="/dashboard"; } else{ errorToast('Failed'); }}}
</script> --}}

<script>
    async function LoginSubmit() {

        let email = document.getElementById('email').value;
        let password = document.getElementById('password').value;

        //validation
        if(email.length === 0){
            errorToast('Email Required');
        }else if(password.length === 0){

            errorToast('Password Required');

        }else{

        // Jodi shob thik thake taile else block e Ajax Request chalabo
        //Ajax Request

        showLoader();

        let response = await axios.post("/user-login",{email:email , password:password});

        hideLoader();
            if(response.status === 200 &&  response.data['status'] === 'success' ){

                window.location.href=("/dashboard");

            }else{

                errorToast('Something Went Wrong , Try Again Latter');
            }
        }
    }
</script>


