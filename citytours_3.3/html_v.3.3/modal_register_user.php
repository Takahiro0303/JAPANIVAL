<div class="modal fade" id="modal_register_user" tabindex="-1" role="dialog" aria-labelledby="myReviewLabel" aria-hidden="true" style="overflow-y: auto;">
    <div class="modal-dialog" > <!-- ここにstyle="width: 400px;"を入れれば、広い画面ではちょうど良いが、画面を狭くすると微妙にずれる。 -->
        <div class="modal-content">

                <div id="modal_register_user" >
                    <div class="text-center"><img src="img/japanival_logo.png" width="240" height="70" alt="JAPANIVAL" data-retina="true" style="max-width: 100%;height: auto;" ></div>
                    <hr>
                    <form method="POST" action="" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" id="r_u_nick_name" name="nick_name" class="form-control"  placeholder="Username">
                            <p class="error error_nick_name"></p>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" id="r_u_email" name="email" class="form-control" placeholder="Email">
                            <p class="error error_email"></p>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" id="r_u_password" name="password" class="form-control" id="password1" placeholder="Password">
                            <p class="error error_password"></p>
                        </div>
                        <div class="form-group">
                            <label>Confirm password</label>
                            <input type="password" id="r_u_confirm_password" name="confirm_password" class="form-control" id="password2" placeholder="Confirm password">
                            <p class="error error_confirm_password"></p>
                        </div>
                        <div class="form-group">
                            <label>Nationality</label>
                            <select class="form-control" id="r_u_nationality" name="nationality" id="nationality" placeholder="Nationality">
                                <option value="nationality">Nationality</option>
                                <option value="Afganistan">Afghanistan</option>
                                <option value="Albania">Albania</option>
                                <option value="Algeria">Algeria</option>
                                <option value="American Samoa">American Samoa</option>
                                <option value="Andorra">Andorra</option>
                                <option value="Angola">Angola</option>
                                <option value="Anguilla">Anguilla</option>
                                <option value="Antigua &amp; Barbuda">Antigua &amp; Barbuda</option>  
                                <option value="Argentina">Argentina</option>
                                <option value="Armenia">Armenia</option>
                                <option value="Aruba">Aruba</option>
                                <option value="Australia">Australia</option>
                                <option value="Austria">Austria</option>
                                <option value="Azerbaijan">Azerbaijan</option>
                                <option value="Bahamas">Bahamas</option>
                                <option value="Bahrain">Bahrain</option>
                                <option value="Bangladesh">Bangladesh</option>
                                <option value="Barbados">Barbados</option>
                                <option value="Belarus">Belarus</option>
                                <option value="Belgium">Belgium</option>
                                <option value="Belize">Belize</option>
                                <option value="Benin">Benin</option>
                                <option value="Bermuda">Bermuda</option>
                                <option value="Bhutan">Bhutan</option>
                                <option value="Bolivia">Bolivia</option>
                                <option value="Bonaire">Bonaire</option>
                                <option value="Bosnia &amp; Herzegovina">Bosnia &amp; Herzegovina</option>
                                <option value="Botswana">Botswana</option>
                                <option value="Brazil">Brazil</option>
                                <option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
                                <option value="Brunei">Brunei</option>
                                <option value="Bulgaria">Bulgaria</option>
                                <option value="Burkina Faso">Burkina Faso</option>
                                <option value="Burundi">Burundi</option>
                                <option value="Cambodia">Cambodia</option>
                                <option value="Cameroon">Cameroon</option>
                                <option value="Canada">Canada</option>
                                <option value="Canary Islands">Canary Islands</option>
                                <option value="Cape Verde">Cape Verde</option>
                                <option value="Cayman Islands">Cayman Islands</option>
                                <option value="Central African Republic">Central African Republic</option>
                                <option value="Chad">Chad</option>
                                <option value="Channel Islands">Channel Islands</option>
                                <option value="Chile">Chile</option>
                                <option value="China">China</option>
                                <option value="Christmas Island">Christmas Island</option>
                                <option value="Cocos Island">Cocos Island</option>
                                <option value="Colombia">Colombia</option>
                                <option value="Comoros">Comoros</option>
                                <option value="Congo">Congo</option>
                                <option value="Cook Islands">Cook Islands</option>
                                <option value="Costa Rica">Costa Rica</option>
                                <option value="Cote DIvoire">Cote D'Ivoire</option>
                                <option value="Croatia">Croatia</option>
                                <option value="Cuba">Cuba</option>
                                <option value="Curaco">Curacao</option>
                                <option value="Cyprus">Cyprus</option>
                                <option value="Czech Republic">Czech Republic</option>
                                <option value="Denmark">Denmark</option>
                                <option value="Djibouti">Djibouti</option>
                                <option value="Dominica">Dominica</option>
                                <option value="Dominican Republic">Dominican Republic</option>
                                <option value="East Timor">East Timor</option>
                                <option value="Ecuador">Ecuador</option>
                                <option value="Egypt">Egypt</option>
                                <option value="El Salvador">El Salvador</option>
                                <option value="Equatorial Guinea">Equatorial Guinea</option>
                                <option value="Eritrea">Eritrea</option>
                                <option value="Estonia">Estonia</option>
                                <option value="Ethiopia">Ethiopia</option>
                                <option value="Falkland Islands">Falkland Islands</option>
                                <option value="Faroe Islands">Faroe Islands</option>
                                <option value="Fiji">Fiji</option>
                                <option value="Finland">Finland</option>
                                <option value="France">France</option>
                                <option value="French Guiana">French Guiana</option>
                                <option value="French Polynesia">French Polynesia</option>
                                <option value="French Southern Ter">French Southern Ter</option>
                                <option value="Gabon">Gabon</option>
                                <option value="Gambia">Gambia</option>
                                <option value="Georgia">Georgia</option>
                                <option value="Germany">Germany</option>
                                <option value="Ghana">Ghana</option>
                                <option value="Gibraltar">Gibraltar</option>
                                <option value="Great Britain">Great Britain</option>
                                <option value="Greece">Greece</option>
                                <option value="Greenland">Greenland</option>
                                <option value="Grenada">Grenada</option>
                                <option value="Guadeloupe">Guadeloupe</option>
                                <option value="Guam">Guam</option>
                                <option value="Guatemala">Guatemala</option>
                                <option value="Guinea">Guinea</option>
                                <option value="Guyana">Guyana</option>
                                <option value="Haiti">Haiti</option>
                                <option value="Hawaii">Hawaii</option>
                                <option value="Honduras">Honduras</option>
                                <option value="Hong Kong">Hong Kong</option>
                                <option value="Hungary">Hungary</option>
                                <option value="Iceland">Iceland</option>
                                <option value="India">India</option>
                                <option value="Indonesia">Indonesia</option>
                                <option value="Iran">Iran</option>
                                <option value="Iraq">Iraq</option>
                                <option value="Ireland">Ireland</option>
                                <option value="Isle of Man">Isle of Man</option>
                                <option value="Israel">Israel</option>
                                <option value="Italy">Italy</option>
                                <option value="Jamaica">Jamaica</option>
                                <option value="Japan">Japan</option>
                                <option value="Jordan">Jordan</option>
                                <option value="Kazakhstan">Kazakhstan</option>
                                <option value="Kenya">Kenya</option>
                                <option value="Kiribati">Kiribati</option>
                                <option value="Korea North">Korea North</option>
                                <option value="Korea Sout">Korea South</option>
                                <option value="Kuwait">Kuwait</option>
                                <option value="Kyrgyzstan">Kyrgyzstan</option>
                                <option value="Laos">Laos</option>
                                <option value="Latvia">Latvia</option>
                                <option value="Lebanon">Lebanon</option>
                                <option value="Lesotho">Lesotho</option>
                                <option value="Liberia">Liberia</option>
                                <option value="Libya">Libya</option>
                                <option value="Liechtenstein">Liechtenstein</option>
                                <option value="Lithuania">Lithuania</option>
                                <option value="Luxembourg">Luxembourg</option>
                                <option value="Macau">Macau</option>
                                <option value="Macedonia">Macedonia</option>
                                <option value="Madagascar">Madagascar</option>
                                <option value="Malaysia">Malaysia</option>
                                <option value="Malawi">Malawi</option>
                                <option value="Maldives">Maldives</option>
                                <option value="Mali">Mali</option>
                                <option value="Malta">Malta</option>
                                <option value="Marshall Islands">Marshall Islands</option>
                                <option value="Martinique">Martinique</option>
                                <option value="Mauritania">Mauritania</option>
                                <option value="Mauritius">Mauritius</option>
                                <option value="Mayotte">Mayotte</option>
                                <option value="Mexico">Mexico</option>
                                <option value="Midway Islands">Midway Islands</option>
                                <option value="Moldova">Moldova</option>
                                <option value="Monaco">Monaco</option>
                                <option value="Mongolia">Mongolia</option>
                                <option value="Montserrat">Montserrat</option>
                                <option value="Morocco">Morocco</option>
                                <option value="Mozambique">Mozambique</option>
                                <option value="Myanmar">Myanmar</option>
                                <option value="Nambia">Nambia</option>
                                <option value="Nauru">Nauru</option>
                                <option value="Nepal">Nepal</option>
                                <option value="Netherland Antilles">Netherland Antilles</option>
                                <option value="Netherlands">Netherlands (Holland, Europe)</option>
                                <option value="Nevis">Nevis</option>
                                <option value="New Caledonia">New Caledonia</option>
                                <option value="New Zealand">New Zealand</option>
                                <option value="Nicaragua">Nicaragua</option>
                                <option value="Niger">Niger</option>
                                <option value="Nigeria">Nigeria</option>
                                <option value="Niue">Niue</option>
                                <option value="Norfolk Island">Norfolk Island</option>
                                <option value="Norway">Norway</option>
                                <option value="Oman">Oman</option>
                                <option value="Pakistan">Pakistan</option>
                                <option value="Palau Island">Palau Island</option>
                                <option value="Palestine">Palestine</option>
                                <option value="Panama">Panama</option>
                                <option value="Papua New Guinea">Papua New Guinea</option>
                                <option value="Paraguay">Paraguay</option>
                                <option value="Peru">Peru</option>
                                <option value="Phillipines">Philippines</option>
                                <option value="Pitcairn Island">Pitcairn Island</option>
                                <option value="Poland">Poland</option>
                                <option value="Portugal">Portugal</option>
                                <option value="Puerto Rico">Puerto Rico</option>
                                <option value="Qatar">Qatar</option>
                                <option value="Republic of Montenegro">Republic of Montenegro</option>
                                <option value="Republic of Serbia">Republic of Serbia</option>
                                <option value="Reunion">Reunion</option>
                                <option value="Romania">Romania</option>
                                <option value="Russia">Russia</option>
                                <option value="Rwanda">Rwanda</option>
                                <option value="St Barthelemy">St Barthelemy</option>
                                <option value="St Eustatius">St Eustatius</option>
                                <option value="St Helena">St Helena</option>
                                <option value="St Kitts-Nevis">St Kitts-Nevis</option>
                                <option value="St Lucia">St Lucia</option>
                                <option value="St Maarten">St Maarten</option>
                                <option value="St Pierre &amp; Miquelon">St Pierre &amp; Miquelon</option>
                                <option value="St Vincent &amp; Grenadines">St Vincent &amp; Grenadines</option>
                                <option value="Saipan">Saipan</option>
                                <option value="Samoa">Samoa</option>
                                <option value="Samoa American">Samoa American</option>
                                <option value="San Marino">San Marino</option>
                                <option value="Sao Tome &amp; Principe">Sao Tome &amp; Principe</option>
                                <option value="Saudi Arabia">Saudi Arabia</option>
                                <option value="Senegal">Senegal</option>
                                <option value="Serbia">Serbia</option>
                                <option value="Seychelles">Seychelles</option>
                                <option value="Sierra Leone">Sierra Leone</option>
                                <option value="Singapore">Singapore</option>
                                <option value="Slovakia">Slovakia</option>
                                <option value="Slovenia">Slovenia</option>
                                <option value="Solomon Islands">Solomon Islands</option>
                                <option value="Somalia">Somalia</option>
                                <option value="South Africa">South Africa</option>
                                <option value="Spain">Spain</option>
                                <option value="Sri Lanka">Sri Lanka</option>
                                <option value="Sudan">Sudan</option>
                                <option value="Suriname">Suriname</option>
                                <option value="Swaziland">Swaziland</option>
                                <option value="Sweden">Sweden</option>
                                <option value="Switzerland">Switzerland</option>
                                <option value="Syria">Syria</option>
                                <option value="Tahiti">Tahiti</option>
                                <option value="Taiwan">Taiwan</option>
                                <option value="Tajikistan">Tajikistan</option>
                                <option value="Tanzania">Tanzania</option>
                                <option value="Thailand">Thailand</option>
                                <option value="Togo">Togo</option>
                                <option value="Tokelau">Tokelau</option>
                                <option value="Tonga">Tonga</option>
                                <option value="Trinidad &amp; Tobago">Trinidad &amp; Tobago</option>
                                <option value="Tunisia">Tunisia</option>
                                <option value="Turkey">Turkey</option>
                                <option value="Turkmenistan">Turkmenistan</option>
                                <option value="Turks &amp; Caicos Is">Turks &amp; Caicos Is</option>
                                <option value="Tuvalu">Tuvalu</option>
                                <option value="Uganda">Uganda</option>
                                <option value="Ukraine">Ukraine</option>
                                <option value="United Arab Erimates">United Arab Emirates</option>
                                <option value="United Kingdom">United Kingdom</option>
                                <option value="United States of America">United States of America</option>
                                <option value="Uraguay">Uruguay</option>
                                <option value="Uzbekistan">Uzbekistan</option>
                                <option value="Vanuatu">Vanuatu</option>
                                <option value="Vatican City State">Vatican City State</option>
                                <option value="Venezuela">Venezuela</option>
                                <option value="Vietnam">Vietnam</option>
                                <option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
                                <option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
                                <option value="Wake Island">Wake Island</option>
                                <option value="Wallis &amp; Futana Is">Wallis &amp; Futana Is</option>
                                <option value="Yemen">Yemen</option>
                                <option value="Zaire">Zaire</option>
                                <option value="Zambia">Zambia</option>
                                <option value="Zimbabwe">Zimbabwe</option>
                            </select>
                            <p class="error error_nationality"></p>
                        </div>
                        <div class="form-group">
                            <label>Gender</label>
                            <select class="form-control" id="r_u_gender" name="gender" id="gender" placeholder="gender">
                                <option value="male" selected>male</option>
                                <option value="female" selected>female</option>
                                <option value="other" selected>other</option>
                            </select>
                            <p class="error error_gender"></p>
                        </div>
                        <div class="form-group">
                            <label>Level of Japanese</label>
                            <select class="form-control" id="r_u_japanese_level" name="japanese" id="japanese" placeholder="introductory">
                                <option value="introductory" selected>introductory</option>
                                <option value="beginner" selected>beginner</option>
                                <option value="intermediate" selected>intermediate</option>
                                <option value="Advanced" selected>Advanced</option>
                            </select>
                            <p class="error error_japanese_level"></p>
                        </div>
                        <div class="form-group">
                            <label>Comment</label><br>
                            <textarea name="comment" id="r_u_comment" class="form-control" placeholder="Describe who you are"></textarea>
                            <p class="error error_comment"></p>
                        </div>
                        <div class="form-group">
                            <label>Photo</label>
                            <div class="form-group">
                                <input type="file" name="pic_path" id="r_u_pic_path">
                                <p class="error error_pic_path"></p>
                            </div> 
                        </div>
                        <div>
<!--                             <button id="register_user_button" class="btn_full">Create an account</button> なぜページが更新されるのか質問 -->
                            <input type="button" id="register_user_button_c" class="btn_full" value="Create an account">

                        </div>
                    </form>
                </div>
        </div>
    </div>
</div>



<!-- 確認用 -->
<div class="modal fade" id="modal_register_user_confirm" tabindex="-1" role="dialog" aria-labelledby="myReviewLabel" aria-hidden="true" style="overflow-y: auto;max-height: 100%;">
    <div class="modal-dialog" > <!-- ここにstyle="width: 400px;"を入れれば、広い画面ではちょうど良いが、画面を狭くすると微妙にずれる。 -->
        <div class="modal-content">

                <div id="modal_register_user" >
                    <div class="text-center"><img src="img/japanival_logo.png" width="240" height="70" alt="JAPANIVAL" data-retina="true" style="max-width: 100%;height: auto;" ></div>
                    <hr>
                    <p>下記の内容で登録して宜しいですか？</p>
                    <form method="POST" action="" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Username:</label>
                            <p id="r_u_nick_name_s" style="font-size: 15px; text-decoration: underline;"></p>
                        </div>
                        <div class="form-group">
                            <label>Email:</label>
                            <p id="r_u_email_s" style="font-size: 15px; text-decoration: underline;"></p>
                        </div>
                        <div class="form-group">
                            <label>Password:</label>
                            <p type="password" id="r_u_password_s_a" style="font-size: 15px; text-decoration: underline;"></p>
                            <input type="hidden" id="r_u_password_s" value="">
                        </div>
<!--                         <div class="form-group">
                            <label>Confirm password:</label>
                            <p id="r_u_confirm_password_s" style="font-size: 15px; text-decoration: underline;"></p>
                        </div> -->
                        <div class="form-group">
                            <label>Nationality:</label>
                            <p id="r_u_nationality_s" style="font-size: 15px; text-decoration: underline;"></p>
                        </div>
                        <div class="form-group">
                            <label>Gender:</label>
                            <p id="r_u_gender_s" style="font-size: 15px; text-decoration: underline;"></p>
                        </div>
                        <div class="form-group">
                            <label>Level of Japanese:</label>
                            <p id="r_u_japanese_level_s" style="font-size: 15px; text-decoration: underline;"></p>
                        </div>
                        <div class="form-group">
                            <label>Comment:</label><br>
                            <p id="r_u_comment_s" style="font-size: 15px; text-decoration: underline;"></p>
                        </div>
                        <div class="form-group">
                            <label>Photo:</label>
                            <div class="form-group">
                            <img src="">
                            </div> 
                        </div>
                        <div>
<!--                             <button id="register_user_button" class="btn_full">Create an account</button> なぜページが更新されるのか質問 -->
                            <input type="button" id="register_user_button_r" class="btn_full" value="Register">
                            <input type="button" id="register_user_button_b" class="btn_full" value="Back">
                        </div>
                    </form>
                </div>
        </div>
    </div>
</div>


<!-- 登録完了通知モーダル -->

<div class="modal fade" id="modal_register_user_result" tabindex="-1" role="dialog" aria-labelledby="myReviewLabel" aria-hidden="true" style="overflow-y: auto;max-height: 100%;">
    <div class="modal-dialog" > <!-- ここにstyle="width: 400px;"を入れれば、広い画面ではちょうど良いが、画面を狭くすると微妙にずれる。 -->
        <div class="modal-content">

                <div id="modal_register_user" >
                    <div class="text-center"><img src="img/japanival_logo.png" width="240" height="70" alt="JAPANIVAL" data-retina="true" style="max-width: 100%;height: auto;" ></div>
                    <hr>
                    <p>登録が完了しました。</p>
                    <br>
                    <input type="button" id="signin_modal_button" class="btn_full" value="Sign in">
                </div>
        </div>
    </div>
</div>


