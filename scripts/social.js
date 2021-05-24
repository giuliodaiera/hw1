function fetchPosts() {
    fetch("fetch_post.php").then(fetchResponse).then(fetchPostsJson);
}

function fetchResponse(response) {
    if (!response.ok) {return null};
    return response.json();
}

function fetchPostsJson(json){
    const posts = document.getElementById('posts_container');

    for(let item of json){

        const postContainer = creaNodoPost(item);
        posts.appendChild(postContainer);

    }
}

function creaNodoPost(item){

    const postContainer = document.createElement('div');
    postContainer.className = "post";
    postContainer.id = item.username;

    const headerContainer = document.createElement('div');
    headerContainer.className = "box1";
    postContainer.appendChild(headerContainer);


    const nameSpace = document.createElement('div');
    nameSpace.className = "box1_left";
    headerContainer.appendChild(nameSpace);

    const nameContainer = document.createElement('label');
    nameContainer.className = "nome";
    nameSpace.appendChild(nameContainer);
    nameContainer.textContent = "@" + item.username;

    const timeSpace = document.createElement('div');
    timeSpace.className = "box1_right";
    headerContainer.appendChild(timeSpace);

    const timeContainer = document.createElement('span');
    timeContainer.className = "time";
    timeSpace.appendChild(timeContainer);
    timeContainer.textContent = item.time;

    const innerContainer = document.createElement('div');
    innerContainer.className = "box2";
    postContainer.appendChild(innerContainer);

    const contentContainer = document.createElement('p');
    contentContainer.className = "contenuto";
    innerContainer.appendChild(contentContainer);
    contentContainer.textContent = item.content.text;

    const lastContainer = document.createElement('div');
    lastContainer.className = "box3";
    lastContainer.id = "box3-" + item.username;
    postContainer.appendChild(lastContainer);

    const nlikesSpace = document.createElement('div');
    nlikesSpace.className = "box3_nlikes";
    lastContainer.appendChild(nlikesSpace);

    const likeContainer = document.createElement('img');
    likeContainer.id = "like-container-" + item.postid;
    if(item.liked == 1){
        likeContainer.className = "like";
        nlikesSpace.appendChild(likeContainer);
        likeContainer.src = "./images/heart_red.png";
    }
    else{
        likeContainer.className = "unlike";
        nlikesSpace.appendChild(likeContainer);
        likeContainer.src = "./images/heart.png";
    }
    
    likeContainer.addEventListener('click', function() {clickToAddLike(item.postid)});

    const nlikes = document.createElement('label');
    nlikes.className = "nlikes";
    nlikes.id = "nlikes-" + item.postid;
    nlikesSpace.appendChild(nlikes);
    nlikes.textContent = item.nlikes;

    const nCommentsSpace = document.createElement('div');
    nCommentsSpace.className = "box3_nComments";
    lastContainer.appendChild(nCommentsSpace);

    const commentContainer = document.createElement('img');
    commentContainer.className = "comment";
    commentContainer.id = "comment-" + item.postid;
    nCommentsSpace.appendChild(commentContainer);
    commentContainer.src = "./images/comment.png";
    commentContainer.addEventListener('click', function() {viewComments(item.postid)});

    const nComments = document.createElement('label');
    nComments.className = "nComments";
    nComments.id = "nComments-" + item.postid;
    nCommentsSpace.appendChild(nComments);
    nComments.textContent = item.ncomments;

    const likeListContainer = document.createElement('div');
    likeListContainer.className = "likeListContainer";
    likeListContainer.id = "likeListContainer-" + item.postid;
    postContainer.appendChild(likeListContainer);

    const likeList = document.createElement('span');
    likeList.className = "likeList";
    likeList.id = "likeList-" + item.postid;
    likeListContainer.appendChild(likeList);
    likeList.textContent = "Clicca per visualizzare i likes";
    likeList.addEventListener('click', function(){addModal(item.postid)});
    if(item.nlikes > 0){
        likeList.setAttribute('style', 'display: block;');
    }
    else{
        likeList.setAttribute('style', 'display: none;');
    }
    
    const commenti = document.createElement('div');
    commenti.className = 'commenti-close';
    commenti.id = 'commenti-'+ item.postid;
    postContainer.appendChild(commenti);

    const input_comment_container = document.createElement('div');
    input_comment_container.className = 'form_input_comment_container';
    
    postContainer.appendChild(input_comment_container);

    const input = document.createElement('input');
    input.className = 'input_comment';
    input.type = "text";
    input.id = "text_comment_" + item.postid;
    input.placeholder = "Insert a comment";
    input.addEventListener('keyup', function() {checkTextCommento(item.postid)});
    input_comment_container.appendChild(input);

    const button_input = document.createElement('button');
    button_input.className = 'submit';
    button_input.textContent = 'Pubblica';
    button_input.disabled = true;
    button_input.id = 'publica_commento' + item.postid;
    input_comment_container.appendChild(button_input);
    button_input.addEventListener('click', function() {clickToPubblicComment(item.postid)});

    return postContainer;
}

function tryEnablePubblicaCommento(postid){
    const canEnable = status_text_comment_ok;

    const submitButton = document.getElementById('publica_commento' + postid);
    submitButton.disabled = !canEnable;
}


function checkTextCommento(postid){
    const input = document.getElementById("text_comment_" + postid);
    const submitButton = document.getElementById('publica_commento' + postid);

    if(!input.value || input.value === ''){
        submitButton.disabled = true;
    }
    else{
        // input valido
        submitButton.disabled = false;
    }
}

function clickToAddLike(postid){
    const image = document.getElementById("like-container-" + postid);
    
    const formData = new FormData();
    formData.append('postid', postid);

    if(image.className == 'unlike'){
        fetch("add_like.php", {method: "post", body: formData }).then(fetchResponse).then(updateNumLikes);
    }else{
        fetch("remove_like.php", {method: "post", body: formData }).then(fetchResponse).then(updateNumLikes);
    }

}

function updateNumLikes(json) {
    const image = document.getElementById('like-container-' + json.postid);
    const likeLabel = document.getElementById('nlikes-' + json.postid);
    const clickViewLikes = document.getElementById("likeList-" + json.postid);

    likeLabel.textContent = json.nlikes;

    if(json.nlikes > 0){
        clickViewLikes.setAttribute('style', 'display: block;');
    }
    else{
        clickViewLikes.setAttribute('style', 'display: none;');
    }

    if(image.className == 'unlike'){
        image.src = "./images/heart_red.png";
        image.className = "like";
    }
    else{
        image.src = "./images/heart.png";
        image.className = "unlike";
    }
}

function clickToPubblicComment(postid){
    const textContainer = document.getElementById('text_comment_' + postid);
    const text = textContainer.value;

    const formData = new FormData();
    formData.append('postid', postid);
    formData.append('text', text);

    fetch("add_comment.php", {method: 'post', body: formData}).then(fetchResponse).then(fetchCommentsJsonAfterInsert);
}

function fetchCommentsJsonAfterInsert(json){
    if(!json) return;
    viewComments(json.postid, true);

    const textContainer = document.getElementById('text_comment_' + json.postid);
    const submitButton = document.getElementById('publica_commento' + json.postid);

    textContainer.value = '';
    submitButton.disabled = true;
}

function viewComments(postid, isInsertOperation = false){
    const comments = document.getElementById('commenti-' + postid);

    if(!isInsertOperation){
        if(comments.className == "commenti-open"){
            comments.className = "commenti-close";
        } else{
            const formData = new FormData();
            formData.append('postid', postid);
            fetch("fetch_comments.php", {method: 'post', body: formData}).then(fetchResponse).then(fetchCommentsJson);
            fetch("fetch_num_comments.php", {method: 'post', body: formData}).then(fetchResponse).then(updateNumComments);
        }
    }
    else{
        const formData = new FormData();
        formData.append('postid', postid);
        fetch("fetch_comments.php", {method: 'post', body: formData}).then(fetchResponse).then(fetchCommentsJson);
        fetch("fetch_num_comments.php", {method: 'post', body: formData}).then(fetchResponse).then(updateNumComments);
    }
}

function updateNumComments(json){
    const ncommentsContainer = document.getElementById("nComments-" + json.postid);
    ncommentsContainer.textContent = json.ncomments;
}

function fetchCommentsJson(json){
    if(!json || json.length < 1) return;

    const box_comment = document.getElementById('commenti-' + json[0].postid);
    box_comment.innerHTML = '';
    for(let item of json){

        const commentContainer = creaNodoCommento(item);
        box_comment.appendChild(commentContainer);

    }

    box_comment.className = "commenti-open";
}

function creaNodoCommento(item){
    const commentContainer = document.createElement('div');
    commentContainer.className = "comment_text";
    commentContainer.id = item.id;

    const headerContainer = document.createElement('div');
    headerContainer.className = "box1_text";
    commentContainer.appendChild(headerContainer);

    const nameSpace = document.createElement('div');
    nameSpace.className = "box1_left_text";
    headerContainer.appendChild(nameSpace);

    const nameContainer = document.createElement('label');
    nameContainer.className = "nome";
    nameSpace.appendChild(nameContainer);
    nameContainer.textContent = "@" + item.username;

    const timeSpace = document.createElement('div');
    timeSpace.className = "box1_right_text";
    headerContainer.appendChild(timeSpace);

    const timeContainer = document.createElement('span');
    timeContainer.className = "time_text";
    timeSpace.appendChild(timeContainer);
    timeContainer.textContent = item.time;

    const innerContainer = document.createElement('div');
    innerContainer.className = "box2_text";
    commentContainer.appendChild(innerContainer);

    const contentContainer = document.createElement('p');
    contentContainer.className = "contenuto_text";
    innerContainer.appendChild(contentContainer);
    contentContainer.textContent = item.text;

    return commentContainer;
}


function toggleModal(){
    document.querySelector('.modal').setAttribute('style', 'display:none');
}

function addModal(postid){

    const formData = new FormData();
    formData.append('postid', postid);
    fetch("view_likes.php", {method: 'post', body: formData}).then(fetchResponse).then(viewAllLikes);

}

document.getElementById('x_close').addEventListener('click', toggleModal);

function viewAllLikes(json){

    const like = document.getElementById('allContainer');

    for(let item of json){

        const userLikeContainer = creaNodoViewLikes(item);
        like.appendChild(userLikeContainer);
    }
    document.querySelector('.modal').setAttribute('style', 'display:flex');
}

function creaNodoViewLikes(item){
    const userLikeContainer = document.createElement('div');
    userLikeContainer.className = "post";
    userLikeContainer.id = item.username;

    const usernameContainer = document.createElement('p');
    usernameContainer.className="username_like";
    usernameContainer.id = "username_like-" + item.username;
    usernameContainer.textContent = '@' + item.username;
    return userLikeContainer;
}



fetchPosts();