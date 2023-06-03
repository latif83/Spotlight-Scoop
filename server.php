<?php

include "db.php";

// Set headers to allow cross-origin requests
header("Access-Control-Allow-Origin: *"); // Allow requests from any origin
header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Allow the HTTP methods: GET, POST, OPTIONS
header("Access-Control-Allow-Headers: Origin, Content-Type, X-Requested-With"); // Allow additional headers

class actions extends Database
{

    function getCategories()
    {
        $conn = $this->connect();

        // Query the database for all categories
        $sql = "SELECT * FROM categories";
        $result = $conn->query($sql);

        // Check if there are any categories
        if ($result->num_rows > 0) {
            // Loop through each row and add the category to the $categories array
            while ($row = $result->fetch_assoc()) {
                $categories[] = $row;
            }
            $resp['status'] = 'success';
            $resp['data'] = $categories;
        } else {
            $resp['status'] = 'error';
            $resp['message'] = 'No categories found';
        }

        // Query the database for all categories
        $sql = "SELECT * FROM subcategories";
        $result = $conn->query($sql);

        // Check if there are any categories
        if ($result->num_rows > 0) {
            // Loop through each row and add the category to the $subcategories array
            while ($row = $result->fetch_assoc()) {
                $subcategories[] = $row;
            }
            $resp['status'] = 'success';
            $resp['subcategories'] = $subcategories;
        } else {
            $resp['status'] = 'error';
            $resp['message'] = 'No categories and subcategories found';
        }

        return json_encode($resp);
    }

    function getAllresources()
    {
        $conn = $this->connect();

        if (isset($_GET['cat'])) {
            $cat = $_GET['cat'];

            $sql = "SELECT * FROM resources WHERE category='$cat' ORDER BY resource_id DESC";
        } else {
            // Query the database for all categories
            $sql = "SELECT * FROM resources ORDER BY resource_id DESC";
        }

        $result = $conn->query($sql);

        // Check if there are any categories
        if ($result->num_rows > 0) {
            // Loop through each row and add the category to the $categories array
            while ($row = $result->fetch_assoc()) {
                $categories[] = $row;
            }
            $resp['status'] = 'success';
            $resp['data'] = $categories;
        } else {
            $resp['status'] = 'error';
            $resp['message'] = 'No resources found';
        }

        return json_encode($resp);
    }
    function getCounts()
    {
        $conn = $this->connect();

        // Query the database for all resources count
        $sql = "SELECT COUNT(*) AS count FROM resources";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $resources = $row['count'];
        $resp['resources'] = $resources;

        // Query the database for all categories count
        $sql = "SELECT COUNT(*) AS count FROM categories";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $resources = $row['count'];
        $resp['categories'] = $resources;

        // Query the database for all sub-categories count
        $sql = "SELECT COUNT(*) AS count FROM subcategories";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $resources = $row['count'];
        $resp['subcategories'] = $resources;

        return json_encode($resp);
    }

    function add_category()
    {

        $conn = $this->connect();

        // Get the form data
        $categoryName = $_POST['categoryName'];
        $categoryImage = $_FILES['categoryImage']['name'];

        // Check if the category name and image were provided
        if ($categoryName && $categoryImage) {

            // Get file extension
            $file_ext = pathinfo($_FILES["categoryImage"]["name"], PATHINFO_EXTENSION);

            // Upload the image to the server
            $target_dir = "images/uploads/";
            $target_file = $target_dir . $categoryName . '.' . $file_ext;
            move_uploaded_file($_FILES["categoryImage"]["tmp_name"], $target_file);

            // TODO: Insert the category into the database
            // You can use the $categoryName and $categoryImage variables to insert the data into your database

            $sql = "INSERT INTO categories(category_name,image_url) values('$categoryName','$target_file')";

            if ($conn->query($sql)) {

                // Return a success message
                $response = array(
                    'status' => 'success',
                    'message' => 'Category added successfully'
                );
                echo json_encode($response);

            }


        } else {
            // Return an error message
            $response = array(
                'status' => 'error',
                'message' => 'Please provide a category name and image'
            );
            echo json_encode($response);
        }

    }

    function edit_category()
    {

        $conn = $this->connect();

        // Get the form data
        $categoryName = $_POST['editCategoryName'];
        $categoryImage = $_FILES['editCategoryImage']['name'];
        $cat_id = $_POST['cat_id'];

        // Check if the category name and image were provided
        if ($categoryName && $categoryImage) {

            // Get file extension
            $file_ext = pathinfo($_FILES["editCategoryImage"]["name"], PATHINFO_EXTENSION);

            // Upload the image to the server
            $target_dir = "images/uploads/";
            $target_file = $target_dir . $categoryName . '.' . $file_ext;
            move_uploaded_file($_FILES["editCategoryImage"]["tmp_name"], $target_file);

            // TODO: update the category in the database
            // You can use the $categoryName and $categoryImage variables to insert the data into your database

            $sql = "UPDATE categories SET category_name='$categoryName', image_url='$target_file' WHERE category_id=$cat_id";

            if ($conn->query($sql)) {

                // Return a success message
                $response = array(
                    'status' => 'success',
                    'message' => 'Category updated successfully'
                );
                echo json_encode($response);

            }


        } elseif ($categoryName) {

            $sql = "UPDATE categories SET category_name='$categoryName' WHERE category_id=$cat_id";

            if ($conn->query($sql)) {

                // Return a success message
                $response = array(
                    'status' => 'success',
                    'message' => 'Category updated successfully'
                );
                echo json_encode($response);

            }

        } elseif ($categoryImage) {

            // Get file extension
            $file_ext = pathinfo($_FILES["categoryImage"]["name"], PATHINFO_EXTENSION);

            // Upload the image to the server
            $target_dir = "images/uploads/";
            $target_file = $target_dir . $categoryName . '.' . $file_ext;
            move_uploaded_file($_FILES["categoryImage"]["tmp_name"], $target_file);

            // TODO: update the category in the database
            // You can use the $categoryName and $categoryImage variables to insert the data into your database

            $sql = "UPDATE categories SET image_url='$target_file' WHERE category_id=$cat_id";

            if ($conn->query($sql)) {

                // Return a success message
                $response = array(
                    'status' => 'success',
                    'message' => 'Category updated successfully'
                );
                echo json_encode($response);

            }

        } else {
            // Return an error message
            $response = array(
                'status' => 'error',
                'message' => 'Please provide a category name and image'
            );
            echo json_encode($response);
        }

    }

    function delete_category()
    {

        $conn = $this->connect();

        $cat_id = $_POST['cat_id'];

        $sql = "DELETE from categories WHERE category_id=$cat_id";

        if ($conn->query($sql)) {

            $resp = array(
                'status' => 'success',
                'msg' => 'Category Removed'
            );

            echo json_encode($resp);

        }

    }

    function insertResource()
    {
        $conn = $this->connect();

        // Retrieve values from the $_POST array
        $resourceName = $_POST['resourceName'];
        $resourceDescription = $_POST['resourceDescription'];
        $resourceURL = $_POST['resourceURL'];
        $rating = $_POST['rating'];
        $category = $_POST['categoryID'];
        // $subcategory = $_POST['subcategoryID'];
        $imageFile = $_FILES['imageFile'];

        // Generate a unique image filename
        $imageFileName = uniqid() . '_' . $imageFile['name'];
        $imagePath = 'uploads/' . $imageFileName;

        // Move the uploaded image file to the desired location
        move_uploaded_file($imageFile['tmp_name'], $imagePath);

        // Set the image URL to be saved in the database
        $imageURL = 'uploads/' . $imageFileName;

        // Prepare and bind the SQL statement
        $stmt = $conn->prepare("INSERT INTO resources (resource_name, resource_description, resource_url, rating, category, image_url) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssdss", $resourceName, $resourceDescription, $resourceURL, $rating, $category, $imageURL);

        // Execute the prepared statement
        $stmt->execute();

        // Check if the insertion was successful
        if ($stmt->affected_rows > 0) {
            $resp['status'] = 'success';
            $resp['message'] = 'Resource inserted successfully';
        } else {
            $resp['status'] = 'error';
            $resp['message'] = 'Failed to insert resource';
        }

        $stmt->close();
        $conn->close();

        return json_encode($resp);
    }


    function deleteResource()
    {

        $conn = $this->connect();

        $resource_id = $_POST['resource_id'];

        $sql = "DELETE from resources WHERE resource_id=$resource_id";

        if ($conn->query($sql)) {

            $resp = array(
                'status' => 'success',
                'msg' => 'Resource Removed'
            );

            echo json_encode($resp);

        }

    }


}

$actions = new actions("localhost", "root", "", "spotlight_scoop");

$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);

switch ($action) {
    case 'get_category':
        echo $actions->getCategories();
        break;
    case 'get_resources':
        echo $actions->getAllresources();
        break;
    case 'get_counts':
        echo $actions->getCounts();
        break;
    case 'add_category':
        echo $actions->add_category();
        break;
    case 'edit_category':
        echo $actions->edit_category();
        break;
    case 'delete_category':
        echo $actions->delete_category();
        break;
    case 'add_resource':
        echo $actions->insertResource();
        break;
    case 'delete_resource':
         echo $actions->deleteResource();
        break;
}

// $data = json_decode(file_get_contents("php://input"));

// echo json_encode($data->name);

?>