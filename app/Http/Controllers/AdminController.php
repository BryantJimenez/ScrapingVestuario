<?php

namespace App\Http\Controllers;

use Goutte\Client;
use Illuminate\Http\Request;
use Exception;
use Excel;

class AdminController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        $client=new Client();
        $crawler=$client->request('GET', 'https://www.vestuariolaboral.com');

        $categories=$this->menuData($crawler);

        return view('admin.home', compact('categories'));
    }

    public function menuData($crawler) {
        $categories=$crawler->filter(".sf-menu.clearfix.menu-content > li")->each(function($categoryNodes) {
            $categoryName=$categoryNodes->filter("a")->first()->text();
            $link=$categoryNodes->filter("a")->first()->attr('href');
            $withFilters=false;
            $withSubcategories=false;

            try {
                $filters=$categoryNodes->filter(".sf-mega.sf-big-submenu .row .submenu")->each(function($filterNodes) {
                    $filter=$filterNodes->filter(".submenu-title")->first()->text();

                    $subcategories=$filterNodes->filter("ul li")->each(function($subcategoryNodes) {
                        $subcategory=$subcategoryNodes->filter("a")->first()->text();
                        $link=$subcategoryNodes->filter("a")->first()->attr('href');
                        return ['subcategory' => $subcategory, 'link' => $link];
                    });

                    return ['filter' => $filter, 'subcategories' => $subcategories];
                });

                if(count($filters)>0) {
                    $withFilters=true;
                }

                foreach ($filters as $filter) {
                    if (count($filter['subcategories'])>0) {
                        $withSubcategories=true;
                        break;
                    }
                }
                $subcategories=[];

            } catch (Exception $e) {

                $filters=[];
                $subcategories=$categoryNodes->filter(".sf-mega.sf-big-submenu .row .submenu ul li")->each(function($subcategoryNodes) {
                    $subcategory=$subcategoryNodes->filter("a")->first()->text();
                    $link=$subcategoryNodes->filter("a")->first()->attr('href');
                    return ['subcategory' => $subcategory, 'link' => $link];
                });

                if (count($subcategories)>0) {
                    $withSubcategories=true;
                }
            }

            return ['category' => $categoryName, 'link' => $link, 'filters' => $filters, 'subcategories' => $subcategories, 'withFilters' => $withFilters, 'withSubcategories' => $withSubcategories];
        });

        return $categories;
    }

    public function scraping(Request $request) {
        $normalTimeLimit=ini_get("max_execution_time");
        ini_set("max_execution_time", 300000);

        $products=[];
        $c=0;

        if ($request->has('subcategory')) {
            $search=request('subcategory');
        } else {
            $search=request('category');
        }

        $client=new Client();
        $crawler=$client->request('GET', $search);

        $count=$crawler->filter(".product-count b")->first()->text();
        $arrayCount=explode('(de ', $count);
        $count=str_replace(')', '', $arrayCount[1]);

        $pages=$count/20;
        if (is_double($pages)) {
            $pages=(int)ceil($pages);
        }

        for ($i=0; $i < $pages; $i++) {

            $page=$i+1;
            $client=new Client();
            $crawler=$client->request('GET', $search.'?p='.$page);

            $productsLink=$crawler->filter(".product-container")->each(function($productNodes) {
                return $productNodes->filter(".right-block .button-container a")->first()->attr('href');
            });

            foreach ($productsLink as $product) {
                $client=new Client();
                $crawler=$client->request('GET', $product);

                $products[$c]=$this->extractData($crawler);
                $c++;
            }
        }

        $this->excel($products);

        ini_set("max_execution_time", $normalTimeLimit);
    }

    public function extractData($crawler) {
        try {
            $product['bread-crumbs']=$crawler->filter("[class='breadcrumbs container']")->first()->text();
        } catch (Exception $e) {
            $product['bread-crumbs']="";
        }

        try {
            $product['nameProduct']=$crawler->filter("[class='page-heading']")->first()->text();
        } catch (Exception $e) {
            $product['nameProduct']="";
        }

        try {
            $product['descProductMin']=$crawler->filter(".desc_container p")->first()->text();
        } catch (Exception $e) {
            $product['descProductMin']="";
        }

        try {
            $product['price']=$crawler->filter("[class='our_price_display']")->first()->text();
        } catch (Exception $e) {
            $product['price']="";
        }

        try {
            $product['deliveryAvailable']=$crawler->filter(".availability-message.availabilityLevel_soonest span")->first()->text();
        } catch (Exception $e) {
            $product['deliveryAvailable']="";
        }

        try {
            $quantityDiscountTitles=$crawler->filter("#quantityDiscount th[data-quantity]")->each(function($titleNodes) {
                return $titleNodes->text();
            });

            $quantityDiscountPrices=$crawler->filter("#quantityDiscount td[data-quantity]")->each(function($priceNodes) {
                return $priceNodes->text();
            });

            $product['quantityDiscount']="";
            for ($i=0; $i < count($quantityDiscountTitles); $i++) { 
                $product['quantityDiscount'].=$quantityDiscountTitles[$i].": ".$quantityDiscountPrices[$i]." - ";
            }
        } catch (Exception $e) {
            $product['quantityDiscount']="";
        }

        try {
            $product['colors']=$crawler->filter("#color_to_pick_list li")->each(function($colorNodes) {
                return $colorNodes->filter("a")->attr('name');
            });
        } catch (Exception $e) {
            $product['colors']="";
        }

        try {
            $product['sizes']=$crawler->filter(".size_selector div")->each(function($sizeNodes) {
                return $sizeNodes->filter("label")->text();
            });
        } catch (Exception $e) {
            $product['sizes']="";
        }

        try {
            $product['images']=$crawler->filter("#thumbs_list_frame li")->each(function($imageNodes) {
                return $imageNodes->filter("a img")->attr('src');
            });
        } catch (Exception $e) {
            $product['images']="";
        }

        try {
            $product['description']=$crawler->filter("[class='rte']")->first()->text();
        } catch (Exception $e) {
            $product['description']="";
        }

        try {
            $product['downloads']=$crawler->filter(".list_attachments li")->each(function($downloadNodes) {
                return $downloadNodes->filter("a")->text()." - ".$downloadNodes->filter("a")->attr('href');
            });
        } catch (Exception $e) {
            $product['downloads']="";
        }

        try {
            $product['relatedProducts']=$crawler->filter("#product_accesories li")->each(function($relatedProductNodes) {
                return $relatedProductNodes->filter("img")->first()->attr('src')." - ".$relatedProductNodes->filter(".right-block .product-name")->first()->text()." - ".$relatedProductNodes->filter(".right-block .content_price")->first()->text()." - ".$relatedProductNodes->filter(".right-block .button-container a")->first()->attr('href');
            });
        } catch (Exception $e) {
            $product['relatedProducts']="";
        }

        try {
            $product['dataBreadcrumbs']=$crawler->filter("[class='yotpo bottomLine']")->first()->attr('data-bread-crumbs');
        } catch (Exception $e) {
            $product['dataBreadcrumbs']="";
        }

        return $product;
    }

    public function excel($products) {
        ob_end_clean();
        ob_start();

        Excel::create('Data Scraping', function($excel) use ($products) {
            $excel->sheet('Productos', function($sheet) use ($products){
                $sheet->row(1, ['Breadcrumbs', 'Nombre', 'Descripción Reducida', 'Precio', 'Envio', 'Precio Por Unidades', 'Colores', 'Tallas', 'Imagénes', 'Descripción Completa', 'Descargas', 'Productos Relacionados', 'Data Breadcrumbs']);

                $data = [];

                foreach ($products as $product) {
                    $row = [];
                    $row[0] = $product['bread-crumbs'];
                    $row[1] = $product['nameProduct'];
                    $row[2] = $product['descProductMin'];
                    $row[3] = $product['price'];
                    $row[4] = $product['deliveryAvailable'];
                    $row[5] = $product['quantityDiscount'];
                    $row[6] = implode(' - ', $product['colors']);
                    $row[7] = implode(' - ', $product['sizes']);
                    $row[8] = implode(' - ', $product['images']);
                    $row[9] = $product['description'];
                    $row[10] = implode(' - ', $product['downloads']);
                    $row[11] = implode(' | ', $product['relatedProducts']);;
                    $row[12] = $product['dataBreadcrumbs'];

                    $data[] = $row;
                    $sheet->appendRow($row);
                }
            });
        })->export('xls');

        ob_flush();
    }
}