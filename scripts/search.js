function fetchPosts() {
    const node = document.getElementById("username_search");
    
    const formData = new FormData();
    formData.append('username', node.value);

    fetch("fetch_post_user_like_or_comment.php", {method: 'post', body: formData }).then(fetchResponse).then(fetchPostsJson);
}

function fetchResponse(response) {
    if (!response.ok) {
        return null
    };

    return response.json();
}

function fetchPostsJson(json){
    const posts = document.getElementById('posts');

    for(let item of json){

        const postContainer = creaNodoPost(item);
        posts.appendChild(postContainer);

    }
}

function creaNodoPost(item){

    const postContainer = document.createElement('div');
    postContainer.className = "post";
    postContainer.id = item.postid;

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

    return postContainer;
}

function checkUsername(){
    const node = document.getElementById("username_search");
    const button = document.getElementById("search_button");
    
    if(!node.value || node.value === ''){
        button.disabled = true;
    }
    else{
        button.disabled = false;
    }
}