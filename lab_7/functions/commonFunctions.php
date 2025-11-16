<?php
//including connect file 
include('./includes/connect.php');
//getting products
function getProducts(){
    global $conn;
    if(!isset($_GET['brand']) && !isset($_GET['category']) )
    {
        $select_query1 = "SELECT * FROM `products` ORDER BY RAND() LIMIT 0,3";
        $result_query1 = mysqli_query($conn, $select_query1);

        while($row_data1 = mysqli_fetch_assoc($result_query1))
        {
            $prod_id = $row_data1['product_id'];
            $prod_title = htmlspecialchars($row_data1['product_title']);
            $prod_desc = htmlspecialchars($row_data1['product_description']);
            $prod_img1 = htmlspecialchars($row_data1['product_image1']);
            $prod_price = number_format($row_data1['product_price'], 2);
            $cat_id = $row_data1['category_id'];
            $brand_id = $row_data1['brand_id'];

            echo 
            "<div class='col-md-4 mb-4'>
                <div class='card h-100 shadow-sm'>
                    <img src='/admin/product_images/$prod_img1' class='card-img-top' alt='$prod_title'>
                    <div class='card-body d-flex flex-column'>
                        <h5 class='card-title'>$prod_title</h5>
                        <p class='card-text flex-grow-1'>$prod_desc</p>
                        <p class='text-primary fw-bold fs-5'>NPR $prod_price</p>
                        <div class='mt-auto d-flex justify-content-between'>
                            <a href='add_to_cart.php?product_id=$prod_id' class='btn btn-info flex-grow-1 me-2'>
                                <i class='fa fa-cart-plus me-1'></i> Add To Cart
                            </a>
                            <a href='product_details.php?id=$prod_id' class='btn btn-secondary flex-grow-1'>
                                View More
                            </a>
                        </div>
                    </div>
                </div>
            </div>";
        }
    }
}

function getCategories(){
    global $conn;

    // Get the currently selected category from URL if any
    $activeCategory = isset($_GET['category']) ? (int)$_GET['category'] : 0;

    // Use the table name as is
    $select_categories = "SELECT * FROM `cateogries`";
    $result_select = mysqli_query($conn, $select_categories);

    while($row_data = mysqli_fetch_assoc($result_select)) {
        $Category_Title = htmlspecialchars($row_data['category_title']);
        $Category_Id = (int)$row_data['category_id'];

        // Highlight the currently active category
        $activeClass = ($Category_Id === $activeCategory) ? 'active-category bg-light text-dark fw-bold' : '';

        echo "
        <li class='nav-item'>
            <a class='nav-link text-light $activeClass' href='displayAll.php?category=$Category_Id'>
                <h4>$Category_Title</h4>
            </a>
        </li>";
    }
}

function getBrands(){
    global $conn;

    // get the currently selected brand from URL if any
    $activeBrand = isset($_GET['brand']) ? (int)$_GET['brand'] : 0;

    $select_brands = "SELECT * FROM `brands`";
    $result_select = mysqli_query($conn, $select_brands);

    while($row_data = mysqli_fetch_assoc($result_select)) {
        $Brand_Title = htmlspecialchars($row_data['brand_title']);
        $Brand_Id = (int)$row_data['brand_id'];

        // check if this brand is the one currently active
        $activeClass = ($Brand_Id === $activeBrand) ? 'active-brand bg-light text-dark fw-bold' : '';

        echo "
        <li class='nav-item'>
            <a class='nav-link text-light $activeClass' href='index.php?brand=$Brand_Id'>
                <h4>$Brand_Title</h4>
            </a>
        </li>";
    }
}

function getProductByBrand(){
    global $conn;
    if(isset($_GET['brand']))
    {
        $brand_id = (int)$_GET['brand'];
        $select_query1 = "SELECT * FROM `products` WHERE brand_id = $brand_id";
        $result_query1 = mysqli_query($conn, $select_query1);
        $num_of_rows = mysqli_num_rows($result_query1);

        if($num_of_rows == 0){
            echo "<h2 class='text-center text-danger'>No data is found under this brand.</h2>";
        }
        while($row_data1 = mysqli_fetch_assoc($result_query1))
        {
            $prod_id = $row_data1['product_id'];
            $prod_title = htmlspecialchars($row_data1['product_title']);
            $prod_desc = htmlspecialchars($row_data1['product_description']);
            $prod_img1 = htmlspecialchars($row_data1['product_image1']);
            $prod_price = number_format($row_data1['product_price'], 2);

            echo 
            "<div class='col-md-4 mb-4'>
                <div class='card h-100 shadow-sm'>
                    <img src='/admin/product_images/$prod_img1' class='card-img-top' alt='$prod_title'>
                    <div class='card-body d-flex flex-column'>
                        <h5 class='card-title'>$prod_title</h5>
                        <p class='card-text flex-grow-1'>$prod_desc</p>
                        <p class='text-primary fw-bold fs-5'>NPR $prod_price</p>
                        <div class='mt-auto d-flex justify-content-between'>
                            <a href='add_to_cart.php?product_id=$prod_id' class='btn btn-info flex-grow-1 me-2'>
                                <i class='fa fa-cart-plus me-1'></i> Add To Cart
                            </a>
                            <a href='product_details.php?id=$prod_id' class='btn btn-secondary flex-grow-1'>
                                View More
                            </a>
                        </div>
                    </div>
                </div>
            </div>";
        }
    }
}

function getProductByCategory(){
    global $conn;
    if(isset($_GET['category']))
    {
        $category_id = (int)$_GET['category'];
        $select_query1 = "SELECT * FROM `products` WHERE category_id = $category_id";
        $result_query1 = mysqli_query($conn, $select_query1);
        $num_of_rows = mysqli_num_rows($result_query1);

        if($num_of_rows == 0){
            echo "<h2 class='text-center text-danger'>No data is found under this category.</h2>";
        }
        while($row_data1 = mysqli_fetch_assoc($result_query1))
        {
            $prod_id = $row_data1['product_id'];
            $prod_title = htmlspecialchars($row_data1['product_title']);
            $prod_desc = htmlspecialchars($row_data1['product_description']);
            $prod_img1 = htmlspecialchars($row_data1['product_image1']);
            $prod_price = number_format($row_data1['product_price'], 2);

            echo 
            "<div class='col-md-4 mb-4'>
                <div class='card h-100 shadow-sm'>
                    <img src='/admin/product_images/$prod_img1' class='card-img-top' alt='$prod_title'>
                    <div class='card-body d-flex flex-column'>
                        <h5 class='card-title'>$prod_title</h5>
                        <p class='card-text flex-grow-1'>$prod_desc</p>
                        <p class='text-primary fw-bold fs-5'>NPR $prod_price</p>
                        <div class='mt-auto d-flex justify-content-between'>
                            <a href='add_to_cart.php?product_id=$prod_id' class='btn btn-info flex-grow-1 me-2'>
                                <i class='fa fa-cart-plus me-1'></i> Add To Cart
                            </a>
                            <a href='product_details.php?id=$prod_id' class='btn btn-secondary flex-grow-1'>
                                View More
                            </a>
                        </div>
                    </div>
                </div>
            </div>";
        }
    }
}

// function getAllProducts(){
//     global $conn;
//     if(!isset($_GET['brand']) && !isset($_GET['category']) )
//     {
//         $select_query1 = "SELECT * FROM products";
//         $result_query1 = mysqli_query($conn, $select_query1);

//         while($row_data1 = mysqli_fetch_assoc($result_query1))
//         {
//             $prod_id = $row_data1['product_id'];
//             echo "<!-- Product ID: $prod_id -->";

//             $prod_title = htmlspecialchars($row_data1['product_title']);
//             $prod_desc = htmlspecialchars($row_data1['product_description']);
//             $prod_img1 = htmlspecialchars($row_data1['product_image1']);
//             $prod_price = number_format($row_data1['product_price'], 2);
//             $cat_id = $row_data1['category_id'];
//             $brand_id = $row_data1['brand_id'];

//             echo 
//             "<div class='col-md-4 mb-4'>
//                 <div class='card h-100 shadow-sm'>
//                     <img src='/admin/product_images/$prod_img1' class='card-img-top' alt='$prod_title'>
//                     <div class='card-body d-flex flex-column'>
//                         <h5 class='card-title'>$prod_title</h5>
//                         <p class='card-text flex-grow-1'>$prod_desc</p>
//                         <p class='text-primary fw-bold fs-5'>NPR $prod_price</p>
//                         <div class='mt-auto d-flex justify-content-between'>
//                             <a href='add_to_cart.php?product_id=$prod_id' class='btn btn-info flex-grow-1 me-2'>
//                                 <i class='fa fa-cart-plus me-1'></i> Add To Cart
//                             </a>
//                             <a href='product_details.php?id=$prod_id' class='btn btn-secondary flex-grow-1'>
//                                 View More
//                             </a>
//                         </div>
//                     </div>
//                 </div>
//             </div>";
//         }
//     }
// }

function getAllProducts(){
    global $conn;

    if (!isset($_GET['brand']) && !isset($_GET['category'])) {
        $sql = "SELECT product_id, product_title, product_description, product_image1, product_price, status
                FROM products
                WHERE status = 'true'
                ORDER BY product_id DESC";
        $result = mysqli_query($conn, $sql);

        // Render product cards
        while ($row = mysqli_fetch_assoc($result)) {
            $prod_id         = (int)$row['product_id'];
            $prod_title_safe = htmlspecialchars($row['product_title'] ?? '', ENT_QUOTES, 'UTF-8');
            $prod_desc_safe  = htmlspecialchars($row['product_description'] ?? '', ENT_QUOTES, 'UTF-8');
            $prod_img1_safe  = htmlspecialchars($row['product_image1'] ?? '', ENT_QUOTES, 'UTF-8');

            // product_price may be varchar; display as-is escaped, and pass numeric fallback
            $price_raw   = (string)($row['product_price'] ?? '0');
            $price_disp  = htmlspecialchars($price_raw, ENT_QUOTES, 'UTF-8');
            $price_float = is_numeric($price_raw) ? (float)$price_raw : 0.0;

            echo "<!-- Product ID: {$prod_id} -->";
            echo "
            <div class='col-md-4 mb-4'>
                <div class='card h-100 shadow-sm'>
                    <img src='/admin/product_images/{$prod_img1_safe}' class='card-img-top' alt='{$prod_title_safe}'>
                    <div class='card-body d-flex flex-column'>
                        <h5 class='card-title'>{$prod_title_safe}</h5>
                        <p class='card-text flex-grow-1'>{$prod_desc_safe}</p>
                        <p class='text-primary fw-bold fs-5'>NPR {$price_disp}</p>
                        <div class='mt-auto d-flex justify-content-between'>
                            <form class='add-to-cart-form flex-grow-1 me-2 m-0'
                                  data-product-id='{$prod_id}'
                                  data-product-title='{$prod_title_safe}'
                                  data-product-price='{$price_float}'
                                  data-product-image='{$prod_img1_safe}'>
                                <div class='input-group input-group-sm'>
                                    <input type='number' name='quantity' class='form-control' value='1' min='1' aria-label='Quantity'>
                                    <button type='submit' class='btn btn-info'>
                                        <i class='fa fa-cart-plus me-1'></i>Add To Cart
                                    </button>
                                </div>
                            </form>

                            <a href='product_details.php?id={$prod_id}' class='btn btn-secondary flex-grow-1'>
                                View More
                            </a>
                        </div>
                    </div>
                </div>
            </div>";
        }

        // Attach handler once
        echo "
        <script>
        (function(){
            function toast(msg, type){
                const prev = document.querySelectorAll('.alert-position-fixed'); prev.forEach(n=>n.remove());
                const el = document.createElement('div');
                el.className = 'alert alert-' + (type||'info') + ' alert-dismissible fade show alert-position-fixed';
                el.style.cssText = 'position:fixed;top:20px;right:20px;z-index:1050;';
                el.innerHTML = msg + '<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>';
                document.body.appendChild(el); setTimeout(()=>{ el.remove(); }, 3000);
            }
            async function addToCart(payload){
                const fd = new FormData();
                fd.append('action','add_to_cart');
                for (const k in payload) fd.append(k, payload[k]);
                const res = await fetch('cart.php', { method:'POST', body:fd });
                if(!res.ok) throw new Error('Network error');
                return await res.json();
            }
            function updateCount(n){
                const c=document.getElementById('cart-count'); if(c) c.textContent = n;
            }
            document.addEventListener('submit', async function(e){
                const form = e.target.closest('.add-to-cart-form');
                if(!form) return;
                e.preventDefault();
                const pid   = form.getAttribute('data-product-id');
                const title = form.getAttribute('data-product-title') || 'Product';
                const price = form.getAttribute('data-product-price') || '0';
                const image = form.getAttribute('data-product-image') || 'default.jpg';
                const qtyEl = form.querySelector('input[name=\"quantity\"]');
                const qty   = Math.max(1, parseInt(qtyEl && qtyEl.value ? qtyEl.value : '1'));
                try{
                    const out = await addToCart({
                        product_id: pid,
                        product_name: title,
                        product_price: price,
                        product_image: image,
                        quantity: qty
                    });
                    if(out && out.success){
                        updateCount(out.cart_count || 0);
                        toast('Added to cart', 'success');
                    } else {
                        toast(out && out.message ? out.message : 'Failed to add to cart', 'danger');
                    }
                }catch(err){
                    console.error(err);
                    toast('Network error while adding to cart', 'danger');
                }
            }, false);
        })();
        </script>";
    }
}

function getAllProductsList() {
    global $conn;
    if (!isset($_GET['brand']) && !isset($_GET['category'])) {
        $select_query = "SELECT * FROM products";
        $result_query = mysqli_query($conn, $select_query);

        while ($row = mysqli_fetch_assoc($result_query)) {
            $prod_id = $row['product_id'];
            $prod_title = htmlspecialchars($row['product_title']);
            $prod_desc = htmlspecialchars($row['product_description']);
            $prod_img1 = htmlspecialchars($row['product_image1']);
            $prod_price = number_format($row['product_price'], 2);

            echo "
            <div class='row mb-2 align-items-center p-2 shadow-sm' style='background:#f8f9fa; border-radius:5px;'>
                <div class='col-md-3 d-flex justify-content-center'>
                    <img src='/admin/product_images/$prod_img1' class='img-fluid rounded' 
                         style='max-width:120px; max-height:120px; object-fit:cover;' 
                         alt='$prod_title'>
                </div>
                <div class='col-md-6'>
                    <h5 class='mb-1'>$prod_title</h5>
                    <p class='text-primary fw-bold mb-0'>NPR $prod_price</p>
                </div>
                <div class='col-md-3 d-flex flex-column justify-content-center'>
                    <a href='add_to_cart.php?product_id=$prod_id' class='btn btn-info mb-1'>
                        <i class='fa fa-cart-plus me-1'></i> Add To Cart
                    </a>
                    <a href='product_details.php?id=$prod_id' class='btn btn-secondary'>
                        View More
                    </a>
                </div>
            </div>";
        }
    }
}
function getAllProductsListAdmin() {
    global $conn;
    if (!isset($_GET['brand']) && !isset($_GET['category'])) {
        $select_query = "SELECT product_id, product_title, product_image1, product_price, status
                         FROM products WHERE status = 'true'
                         ORDER BY product_id DESC";
        $result_query = mysqli_query($conn, $select_query);

        while ($row = mysqli_fetch_assoc($result_query)) {
            $prod_id          = (int)$row['product_id'];
            $prod_title_safe  = htmlspecialchars($row['product_title'] ?? '', ENT_QUOTES, 'UTF-8');
            $prod_img1_safe   = htmlspecialchars($row['product_image1'] ?? '', ENT_QUOTES, 'UTF-8');
            $prod_price_disp  = htmlspecialchars((string)($row['product_price'] ?? ''), ENT_QUOTES, 'UTF-8');
            $status           = (string)($row['status'] ?? '');

            // Image path + alt
            $imgSrc = "/admin/product_images/{$prod_img1_safe}";
            $imgAlt = $prod_title_safe !== '' ? $prod_title_safe : 'Product image';

            // Build confirm message safely for inline JS single quotes in HTML attribute
            $rawTitle = $row['product_title'] ?? '';
            $msg = "Disable (soft delete) this product?\n\n{$rawTitle} (ID: {$prod_id})";
            // Normalize newlines for JS literal
            $msg_js = str_replace(["\r\n", "\r", "\n"], "\\n", $msg);
            // Escape for HTML attribute
            $confirmMsg = htmlspecialchars($msg_js, ENT_QUOTES, 'UTF-8');

            // Status badge
            $badge = ($status === 'true')
                ? "<span class='badge bg-success'>Active</span>"
                : "<span class='badge bg-secondary'>Inactive</span>";

            echo "
            <div class='row mb-2 align-items-center p-2 shadow-sm bg-light rounded-2'>
                <div class='col-md-3 d-flex justify-content-center'>
                    <img src='{$imgSrc}' class='img-fluid rounded'
                         style='max-width:120px; max-height:120px; object-fit:cover;'
                         alt='{$imgAlt}'>
                </div>
                <div class='col-md-6'>
                    <h5 class='mb-1 text-truncate' title='{$prod_title_safe}'>{$prod_title_safe} {$badge}</h5>
                    <p class='text-primary fw-bold mb-0'>NPR {$prod_price_disp}</p>
                </div>
                <div class='col-md-3 d-flex gap-2 justify-content-md-end mt-2 mt-md-0'>
                    <a href='admin_edit_product.php?id={$prod_id}' class='btn btn-sm btn-info'>
                        <i class='fa fa-pen me-1'></i>Edit
                    </a>";

            // Action: Disable (soft delete) when active; Restore when inactive
            // if ($status === 'true') {
                echo "
                    <form action='admin_delete_product_post.php'
                          method='post'
                          onsubmit=\"return confirm('{$confirmMsg}')\"
                          class='m-0'>
                        <input type='hidden' name='id' value='{$prod_id}'>
                        <button type='submit' class='btn btn-sm btn-warning'>
                            <i class='fa fa-ban me-1'></i>Disable
                        </button>
                    </form>";
            // } 
            // else {
            //     // Optional: restore action for inactive
            //     $restoreMsg = htmlspecialchars(
            //         str_replace(["\r\n","\r","\n"], "\\n", "Restore this product?\n\n{$rawTitle} (ID: {$prod_id})"),
            //         ENT_QUOTES,
            //         'UTF-8'
            //     );
            //     echo "
            //         <form action='admin_restore_product_post.php'
            //               method='post'
            //               onsubmit=\"return confirm('{$restoreMsg}')\"
            //               class='m-0'>
            //             <input type='hidden' name='id' value='{$prod_id}'>
            //             <button type='submit' class='btn btn-sm btn-success'>
            //                 <i class='fa fa-rotate-left me-1'></i>Restore
            //             </button>
            //         </form>";
            // }

            echo "
                </div>
            </div>";
        }
    }
}




// function getAllProducts()
// {
//     global $conn;

//     // Only show all products if no filter is applied
//     if (!isset($_GET['brand']) && !isset($_GET['category'])) {

//         $query = "SELECT * FROM `products`";
//         $result = mysqli_query($conn, $query);

//         if (!$result) {
//             die("Query failed: " . mysqli_error($conn));
//         }

//         while ($row = mysqli_fetch_assoc($result)) {
//             $prod_id    = $row['product_id'];
//             $prod_title = htmlspecialchars($row['product_title']);
//             $prod_desc  = htmlspecialchars($row['product_description']);
//             $prod_img1  = htmlspecialchars($row['product_image1']);



function searchProduct(){
    global $conn;
    if(isset($_GET['search_data_product']))

    {
      $search_data_value = $_GET['search_data'];
       $select_query1 = "SELECT * FROM products WHERE product_keywords LIKE '%$search_data_value%' order by rand() ";
          $result_query1 = mysqli_query($conn, $select_query1);
          // $row_data1 = mysqli_fetch_assoc($result_query1);
          // echo $row_data ['product_title'];
          while($row_data1 = mysqli_fetch_assoc($result_query1))
          {
            $prod_id = $row_data1['product_id'];
            $prod_title = $row_data1['product_title'];
            $prod_desc = $row_data1['product_description'];
            $prod_img1 = $row_data1['product_image1'];
            $prod_price = $row_data1['product_price'];  
            $cat_id = $row_data1['category_id'];
            $brand_id = $row_data1['brand_id'];
            echo 
            "<div class='col-md-4'>
             
              <div class='card' style='width: 18rem;'>
                <img src='/admin/product_images/$prod_img1' class='card-img-top' alt='...'>
                <div class='card-body'>
                  <h5 class='card-title'>$prod_title</h5>
                    <p class='card-text'>$prod_desc</p>
                      <a href='#' class='btn btn-info'>Add To Cart</a>
                      <a href='#' class='btn btn-secondary'>View More</a>
                </div>
              </div>
            </div>";
            echo"</br>";
          }
      }

}

function uuidv4()
{
  $data = random_bytes(16);

  $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
  $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
    
  return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

function findProjectRoot(string $startDir = __DIR__): ?string
{
    $dir = realpath($startDir);

    while ($dir && $dir !== DIRECTORY_SEPARATOR) {
        if (file_exists($dir . '/style.css')) {
            return $dir;
        }
        $parent = dirname($dir);
        if ($parent === $dir) break; // reached filesystem root
        $dir = $parent;
    }

    return null;
}


?>
