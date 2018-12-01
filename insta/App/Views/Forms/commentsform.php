<div class="section-header clearfix">
    <h2 class="section-title mr-5">Get New Comments</h2>
    <h3 class="section-title float-right">Available Comments {{ account.system_likes }}</h3>
</div>
<div class="section-content">
    <div class="input-group">
        <input style="width:60%;" type="text" id="postLink" placeholder="Instagram Post Link" class="form-control" />
        <a class="load-button button button--light-outline mt-2" href="#">Import Post</a>
    </div>
    <div class="row m-0 mt-3 mb-3 p-0">
        <div class="col-md-6 p-0">
          <div class="form-group">
                  <select id="instaCat" class="form-control">
                    <option selected val="">Account Category *</option>
                    <option value="all">General</option>
                    <option value="carsnbikes">Cars & Bikes</option>
                    <option value="fahsionnstyle">Fashion & Style</option>
                    <option value="personalntalent">Personal & Talent</option>
                    <option value="petsnanimals">Pets & Animals</option>
                    <option value="fitnessnsports">Fitness & Sports</option>
                    <option value="foodnnutrition">Food & Nutrition</option>
                    <option value="quotesntextes">Quotes & Textes</option>
                    <option value="humournmemes">Humour & Memes</option>
                    <option value="luxurynmotivation">Luxury & Motivation</option>
                  </select>
            </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
              <input type="text" class="form-control" id="maxTotal" placeholder="Total Comments">
          </div>
        </div>
    </div>
    <div class="input-group">
        <input style="width:60%;" type="text" id="postComments" placeholder="Write Comments here !" class="form-control" />
        <a class="load-comments button button--light-outline mt-2" href="#">Add Comments</a>
    </div>
    <div class="tags-elements"><ul class="lists-elements"></ul></div>
    <div class="form-result"></div>
    <div class="clearfix mt-5">
        <div class="row m-0 p-0">
            <input class="fluid button schedule" style="width:40%;" type="submit" value="Save">
        </div>
    </div>
</div>