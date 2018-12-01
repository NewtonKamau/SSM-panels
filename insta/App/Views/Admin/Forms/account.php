<div class="section-header clearfix">
    <h2 class="section-title">User Details</h2>
</div>
<div class="section-content">
    <div class="row m-0 mt-3 mb-3 p-0">
        <div class="col-md-6 m-0 p-0">
          <div class="form-group">
                <label for="username">Username</label><br>
                <input type="text" style="width:80%;" name="acc_username" placeholder="{{ details.user_name}}" id="username" />
          </div>
        </div>
        <div class="col-md-6 m-0 p-0">
          <div class="form-group">
                <label for="email">Email Address</label><br>
                <input type="email" style="width:80%;" name="acc_username" placeholder="{{ details.user_email}}" id="email" />
          </div>
        </div>
        <div class="col-md-12 mt-4 p-0">
            <label for="addedAccounts">Instagram Accounts</label><br>
            {% if accounts is not empty %}
              <div class="aside-list js-loadmore-content" data-loadmore-id="1">
              {% for acc in accounts %}
                  <div data-accid="{{ acc.id }}" class="aside-list-item js-list-item ">
                     <div class="clearfix">
                          <span class="circle"><img src="{{ acc.account_profile }}" width="40px" class="rounded-circle"></span>
                          <div class="inner">
                              <div class="title">{{ acc.account_username }}</div>
                              <div class="sub">Level {{ acc.account_level }}</div>
                          </div>
                      <a class="full-link js-ajaxload-content" href="#"></a>
                      </div>
                  </div>
              {% endfor %}
              </div>            
            {% else %}
                <div class="alert bg-danger text-white">No Instagram Accounts for this user !</div>
            {% endif %}
        </div>
    </div>
    <div class="clearfix mt-5">
        <div class="row m-0 p-0">
            <div style="text-align:center;" class="col-md-12">
                <input class="fluid button schedule" style="width:40%;" type="submit" value="Save">
            </div>
        </div>
    </div>
</div>