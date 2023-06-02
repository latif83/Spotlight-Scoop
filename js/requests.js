
let serverURL = "http://localhost/spotlight_scoop/"

function getCategories(){
    fetch(`${serverURL}server.php?f=get_category`)
    .then(response => response.json())
    .then(data => {
        // console.log(data);

        let cat = document.getElementById('categories')

        let categorySort = document.getElementById("categorySort")

        if(cat){

            data.data.forEach(d => {

                cat.innerHTML += `<span onclick="location.href='?category=${d.category_name}'" class="badge bg-primary m-1 p-2">${d.category_name}</span>`

                categorySort.innerHTML += `
                <option value="${d.category_name}">${d.category_name}</option>
                `
    
            });
        }

    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function getCategoriesAdmin(){
    return fetch(`${serverURL}server.php?f=get_category`)
    .then(response => response.json())
}

function addCategory(formData){
    return fetch(`${serverURL}server.php?f=add_category`, {
      method: 'POST',
      body: formData
    })
    .then(response => {
      if (response.ok) {
        return response.json(); // parse response data as JSON and return it
      } else {
        throw new Error('Network response was not ok');
      }
    })
    .catch(error => {
      console.error('Error:', JSON.stringify(error));
    });
  }

  async function addResource(formData) {
    const response = await fetch(`${serverURL}server.php?f=add_resource`, {
      method: 'POST',
      body: formData
    });
  
    if (response.ok) {
      // The request was successful
      return response.json();
    } else {
      // The request failed
      throw new Error('Network response was not ok');
    }
  }
  

  function editCategory(formData){
    return fetch('../server.php?f=edit_category', {
      method: 'POST',
      body: formData
    })
    .then(response => {
      if (response.ok) {
        return response.json(); // parse response data as JSON and return it
      } else {
        throw new Error('Network response was not ok');
      }
    })
    .catch(error => {
      console.error('Error:', JSON.stringify(error));
    });
  }


  function deleteCategory(formData){
    return fetch('../server.php?f=delete_category', {
      method: 'POST',
      body: formData
    })
    .then(response => {
      if (response.ok) {
        return response.json(); // parse response data as JSON and return it
      } else {
        throw new Error('Network response was not ok');
      }
    })
    .catch(error => {
      console.error('Error:', JSON.stringify(error));
    });
  }
  

function getResources(category){

  let url;

  if(category=="All" || category == undefined){
    url = `${serverURL}server.php?f=get_resources`
  } else{
    url = `${serverURL}server.php?f=get_resources&cat=${category}`
  }

    fetch(url)
    .then(response => response.json())
    .then(data => {
        console.log(data);

        let resourceList = document.getElementById('resourceList')

        let resourceCount = document.getElementById("resourceCount")

        let tbody = document.querySelector("tbody")

        const domain = window.location.origin;

        resourceCount.innerHTML = data.data ? data.data.length : 0

        if(resourceList && data.status == "error"){

          resourceList.innerHTML = `
          
          <div style="text-align: center; color: white;">

          <h3> ${data.message} </h3>

          </div>

          `

          return;

        }

        let resource = {
          title: 'Peaky Blinders',
          image: 'uploads/647a310bb7428_photo_2023-06-02_18-10-30.jpg',
          category: 'TV Shows',
          description: 'A gangster family epic set in 1900s England, centering on a gang who sew razor blades in the peaks of their caps, and their fierce boss Tommy Shelby.',
          rating: '8.80',
          date: '2023-06-02 18:12:27',
          watchURL: 'https://t.me/+QGcN-5tz6vk1OTg0'
        };

        data.data.forEach(d => {


          if(tbody){
            tbody.innerHTML += `

          <tr>
              <td>${d.resource_name}</td>
              <td>${d.resource_description}</td>
              <td><a href="${d.resource_url}" target="_blank"> ${d.resource_url} </a></td>
              <td>${d.rating}</td>
              <td> <img src="${domain}/${d.image_url}" class="img-fluid rounded" style="height:50px;" /> </td>
              <td>${d.category}</td>
              <td>
                <button class="btn btn-primary">Edit</button>
                <button class="btn btn-danger">Delete</button>
              </td>
            </tr>
          
          `
          }

            if(resourceList){

              resourceList.innerHTML += `
                <div onclick="openModal('${encodeURIComponent(JSON.stringify(d))}')" class="movie-item-style-2 movie-item-style-1">
							<img src="${d.image_url}" alt="">
							<!--<div class="hvr-inner">
								<a href="">Preview<i class="ion-android-arrow-dropright"></i> </a>
							</div>-->
							<div class="mv-item-infor">
              <h3 class="text-light" style="color: white;"> ${d.resource_name} </h3>
                            <p style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; margin-bottom:2%;"> ${d.resource_description} </p>
                            <button class="btn btn-dark" onclick="openModal('${encodeURIComponent(JSON.stringify(d))}')" style="margin-bottom:2%;"> Read More... </button>
								<h6><a href="${d.resource_url}" target="_blank">Open telegram link</a></h6>
								<p class="rate"><i class="ion-android-star"></i><span>${d.rating}</span> /10</p>
							</div>
						</div>
                `

            }

        });
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function getCounts() {

    return fetch(`${serverURL}server.php?f=get_counts`)
        .then(response => response.json())

}