<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\ProductGroup;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Создаём категории если их нет
        $categories = [];
        $categories[] = Category::firstOrCreate(['title' => 'Смартфоны'], ['parent_id' => null]);
        $categories[] = Category::firstOrCreate(['title' => 'Ноутбуки'], ['parent_id' => null]);
        $categories[] = Category::firstOrCreate(['title' => 'Наушники'], ['parent_id' => null]);
        $categories[] = Category::firstOrCreate(['title' => 'Планшеты'], ['parent_id' => null]);
        $categories[] = Category::firstOrCreate(['title' => 'Умные часы'], ['parent_id' => null]);

        // Создаём группы товаров если их нет
        $productGroups = [];
        $productGroups[] = ProductGroup::firstOrCreate(['title' => 'iPhone'], ['category_id' => $categories[0]->id]);
        $productGroups[] = ProductGroup::firstOrCreate(['title' => 'MacBook'], ['category_id' => $categories[1]->id]);
        $productGroups[] = ProductGroup::firstOrCreate(['title' => 'AirPods'], ['category_id' => $categories[2]->id]);
        $productGroups[] = ProductGroup::firstOrCreate(['title' => 'iPad'], ['category_id' => $categories[3]->id]);
        $productGroups[] = ProductGroup::firstOrCreate(['title' => 'Apple Watch'], ['category_id' => $categories[4]->id]);

        $products = [
            // Смартфоны
            [
                'title' => 'iPhone 15 Pro',
                'description' => 'Флагманский смартфон Apple с титановым корпусом и чипом A17 Pro',
                'content' => 'iPhone 15 Pro — это революционный смартфон с титановым корпусом авиационного класса. Оснащён мощнейшим чипом A17 Pro, профессиональной камерой 48 Мп и дисплеем Super Retina XDR с ProMotion. Поддержка 5G, Face ID, MagSafe и беспроводной зарядки.',
                'price' => 129990,
                'old_price' => 149990,
                'qty' => 25,
                'article' => 100001,
                'images' => [
                    'https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=800&q=80',
                    'https://images.unsplash.com/photo-1696446702022-0af1fbb4227b?w=800&q=80',
                    'https://images.unsplash.com/photo-1695048064942-89eb9cf6e14a?w=800&q=80',
                ],
                'category_index' => 0,
                'group_index' => 0,
            ],
            [
                'title' => 'iPhone 15',
                'description' => 'Современный смартфон с Dynamic Island и камерой 48 Мп',
                'content' => 'iPhone 15 предлагает все необходимые функции современного смартфона: Dynamic Island для удобного управления уведомлениями, мощную камеру 48 Мп с 2x оптическим зумом, чип A16 Bionic и вседневную батарею. Доступен в ярких цветах.',
                'price' => 89990,
                'old_price' => 99990,
                'qty' => 40,
                'article' => 100002,
                'images' => [
                    'https://images.unsplash.com/photo-1695048133372-a2f14ac655eb?w=800&q=80',
                    'https://images.unsplash.com/photo-1695048133108-4d4904393895?w=800&q=80',
                ],
                'category_index' => 0,
                'group_index' => 0,
            ],
            [
                'title' => 'Samsung Galaxy S24 Ultra',
                'description' => 'Флагман Samsung с ИИ-функциями и S Pen',
                'content' => 'Galaxy S24 Ultra — вершина инженерной мысли Samsung. Оснащён процессором Snapdragon 8 Gen 3, камерой 200 Мп с ИИ-обработкой, встроенным S Pen и дисплеем Dynamic AMOLED 2X с частотой 120 Гц. Титановая рамка и защита Gorilla Armor.',
                'price' => 119990,
                'old_price' => 139990,
                'qty' => 18,
                'article' => 100003,
                'images' => [
                    'https://images.unsplash.com/photo-1610945415295-d9bbf067e59c?w=800&q=80',
                    'https://images.unsplash.com/photo-1658428233067-14a2a543c609?w=800&q=80',
                ],
                'category_index' => 0,
                'group_index' => 0,
            ],
            [
                'title' => 'Xiaomi 14 Pro',
                'description' => 'Флагман Xiaomi с камерой Leica и Snapdragon 8 Gen 3',
                'content' => 'Xiaomi 14 Pro представляет собой идеальный баланс между производительностью и фотографией. Оснащён процессором Snapdragon 8 Gen 3, тройной камерой Leica с сенсором 1", дисплеем LTPO AMOLED и быстрой зарядкой 120 Вт.',
                'price' => 79990,
                'old_price' => 89990,
                'qty' => 30,
                'article' => 100004,
                'images' => [
                    'https://images.unsplash.com/photo-1598327105666-5b89351aff23?w=800&q=80',
                    'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=800&q=80',
                ],
                'category_index' => 0,
                'group_index' => 0,
            ],
            // Ноутбуки
            [
                'title' => 'MacBook Pro 16" M3 Max',
                'description' => 'Профессиональный ноутбук Apple с чипом M3 Max',
                'content' => 'MacBook Pro 16" с чипом M3 Max — это невероятная производительность для профессионалов. Дисплей Liquid Retina XDR, до 128 ГБ памяти, до 8 ТБ SSD, порты Thunderbolt 4, HDMI и SD-кардридер. До 22 часов работы без подзарядки.',
                'price' => 349990,
                'old_price' => 399990,
                'qty' => 8,
                'article' => 200001,
                'images' => [
                    'https://images.unsplash.com/photo-1517336714731-489689fd1ca4?w=800&q=80',
                    'https://images.unsplash.com/photo-1531297484001-80022131f5a1?w=800&q=80',
                ],
                'category_index' => 1,
                'group_index' => 1,
            ],
            [
                'title' => 'MacBook Air 15" M3',
                'description' => 'Тонкий и лёгкий ноутбук с дисплеем 15"',
                'content' => 'MacBook Air 15" с чипом M3 — идеальный баланс между портативностью и производительностью. Безвентиляторный дизайн, дисплей Liquid Retina, до 18 часов работы, два порта Thunderbolt и поддержка двух внешних дисплеев.',
                'price' => 149990,
                'old_price' => 169990,
                'qty' => 22,
                'article' => 200002,
                'images' => [
                    'https://images.unsplash.com/photo-1517336714731-489689fd1ca4?w=800&q=80',
                    'https://images.unsplash.com/photo-1531297484001-80022131f5a1?w=800&q=80',
                ],
                'category_index' => 1,
                'group_index' => 1,
            ],
            [
                'title' => 'ASUS ROG Zephyrus G16',
                'description' => 'Игровой ноутбук с RTX 4090 и OLED-дисплеем',
                'content' => 'ROG Zephyrus G16 — мощный игровой ноутбук в тонком корпусе. Процессор Intel Core Ultra 9, видеокарта NVIDIA GeForce RTX 4090, 32 ГБ RAM, 2 ТБ SSD. OLED-дисплей 240 Гц с точностью цвета 100% DCI-P3. Система охлаждения с жидким металлом.',
                'price' => 299990,
                'old_price' => 349990,
                'qty' => 5,
                'article' => 200003,
                'images' => [
                    'https://images.unsplash.com/photo-1593640408182-31c70c8268f5?w=800&q=80',
                    'https://images.unsplash.com/photo-1603302576837-37561b2e2302?w=800&q=80',
                ],
                'category_index' => 1,
                'group_index' => 1,
            ],
            [
                'title' => 'Dell XPS 15',
                'description' => 'Премиальный ноутбук для работы и творчества',
                'content' => 'Dell XPS 15 сочетает в себе элегантный дизайн и высокую производительность. Процессор Intel Core i9 14-го поколения, NVIDIA GeForce RTX 4060, 32 ГБ RAM, OLED-дисплей 3.5K с точностью цвета 100% DCI-P3. Корпус из алюминия и углеродного волокна.',
                'price' => 189990,
                'old_price' => 219990,
                'qty' => 12,
                'article' => 200004,
                'images' => [
                    'https://images.unsplash.com/photo-1593642632823-8f78536788c6?w=800&q=80',
                    'https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?w=800&q=80',
                ],
                'category_index' => 1,
                'group_index' => 1,
            ],
            // Наушники
            [
                'title' => 'AirPods Pro 2',
                'description' => 'Беспроводные наушники с активным шумоподавлением',
                'content' => 'AirPods Pro 2 предлагают улучшенное активное шумоподавление, адаптивную прозрачность и персонализированное пространственное аудио. Чип H2 обеспечивает лучшее качество звука. Кейс с поддержкой MagSafe и динамиком для поиска.',
                'price' => 24990,
                'old_price' => 29990,
                'qty' => 50,
                'article' => 300001,
                'images' => [
                    'https://images.unsplash.com/photo-1606841837239-c5a1a4a07af7?w=800&q=80',
                    'https://images.unsplash.com/photo-1603351154351-5cf99bc75467?w=800&q=80',
                ],
                'category_index' => 2,
                'group_index' => 2,
            ],
            [
                'title' => 'Sony WH-1000XM5',
                'description' => 'Флагманские наушники с лучшим шумоподавлением',
                'content' => 'Sony WH-1000XM5 — это лучшие беспроводные наушники с активным шумоподавлением. 8 микрофонов, процессор V1, 30 часов работы, быстрая зарядка, мультипоинт подключение. Премиальные материалы и комфорт на весь день.',
                'price' => 34990,
                'old_price' => 39990,
                'qty' => 35,
                'article' => 300002,
                'images' => [
                    'https://images.unsplash.com/photo-1618366712010-f4ae9c647dcb?w=800&q=80',
                    'https://images.unsplash.com/photo-1583394838336-acd977736f90?w=800&q=80',
                ],
                'category_index' => 2,
                'group_index' => 2,
            ],
            [
                'title' => 'Samsung Galaxy Buds2 Pro',
                'description' => 'Компактные наушники с Hi-Fi звуком',
                'content' => 'Galaxy Buds2 Pro предлагают профессиональное качество звука в компактном корпусе. Активное шумоподавление, 360 Audio, IPX7 защита от воды. До 8 часов работы с ANC и до 29 часов с кейсом.',
                'price' => 16990,
                'old_price' => 19990,
                'qty' => 45,
                'article' => 300003,
                'images' => [
                    'https://images.unsplash.com/photo-1610792516484-9727e084e638?w=800&q=80',
                    'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=800&q=80',
                ],
                'category_index' => 2,
                'group_index' => 2,
            ],
            // Планшеты
            [
                'title' => 'iPad Pro 12.9" M2',
                'description' => 'Профессиональный планшет с чипом M2',
                'content' => 'iPad Pro 12.9" с чипом M2 — это настольная производительность в планшете. Дисплей Liquid Retina XDR с ProMotion, поддержка Apple Pencil 2 и Magic Keyboard, 5G connectivity. Идеален для творчества и работы.',
                'price' => 119990,
                'old_price' => 139990,
                'qty' => 15,
                'article' => 400001,
                'images' => [
                    'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?w=800&q=80',
                    'https://images.unsplash.com/photo-1561154464-82e9adf32764?w=800&q=80',
                ],
                'category_index' => 3,
                'group_index' => 3,
            ],
            [
                'title' => 'iPad Air 5',
                'description' => 'Универсальный планшет с чипом M1',
                'content' => 'iPad Air 5 с чипом M1 предлагает невероятную производительность для работы и развлечений. 10.9" дисплей Liquid Retina, поддержка Apple Pencil 2 и Magic Keyboard, Touch ID в кнопке питания. Доступен в ярких цветах.',
                'price' => 64990,
                'old_price' => 74990,
                'qty' => 28,
                'article' => 400002,
                'images' => [
                    'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?w=800&q=80',
                    'https://images.unsplash.com/photo-1561154464-82e9adf32764?w=800&q=80',
                ],
                'category_index' => 3,
                'group_index' => 3,
            ],
            // Умные часы
            [
                'title' => 'Apple Watch Ultra 2',
                'description' => 'Спортивные часы для экстремальных условий',
                'content' => 'Apple Watch Ultra 2 созданы для приключений. Титановый корпус 49 мм, дисплей Retina до 3000 нит, до 36 часов работы, GPS с двумя частотами, датчик глубины до 40 м, сирена 86 дБ. watchOS 10 с новыми виджетами.',
                'price' => 89990,
                'old_price' => 99990,
                'qty' => 12,
                'article' => 500001,
                'images' => [
                    'https://images.unsplash.com/photo-1579586337278-3befd40fd17a?w=800&q=80',
                    'https://images.unsplash.com/photo-1508685096489-7aacd43bd3b1?w=800&q=80',
                ],
                'category_index' => 4,
                'group_index' => 4,
            ],
            [
                'title' => 'Apple Watch Series 9',
                'description' => 'Современные умные часы с новым чипом S9',
                'content' => 'Apple Watch Series 9 с чипом S9 предлагают улучшенную производительность и новые функции. Дисплей Retina до 2000 нит, жест Double Tap, точное определение местоположения, мониторинг здоровья 24/7. До 18 часов работы.',
                'price' => 44990,
                'old_price' => 49990,
                'qty' => 30,
                'article' => 500002,
                'images' => [
                    'https://images.unsplash.com/photo-1579586337278-3befd40fd17a?w=800&q=80',
                    'https://images.unsplash.com/photo-1508685096489-7aacd43bd3b1?w=800&q=80',
                ],
                'category_index' => 4,
                'group_index' => 4,
            ],
            [
                'title' => 'Samsung Galaxy Watch6 Classic',
                'description' => 'Классические умные часы с вращающимся безелем',
                'content' => 'Galaxy Watch6 Classic сочетают традиционный дизайн с современными технологиями. Вращающийся безель, корпус из нержавеющей стали, сапфировое стекло, Wear OS 5, мониторинг здоровья, GPS, NFC. До 40 часов работы.',
                'price' => 39990,
                'old_price' => 44990,
                'qty' => 20,
                'article' => 500003,
                'images' => [
                    'https://images.unsplash.com/photo-1508685096489-7aacd43bd3b1?w=800&q=80',
                    'https://images.unsplash.com/photo-1579586337278-3befd40fd17a?w=800&q=80',
                ],
                'category_index' => 4,
                'group_index' => 4,
            ],
        ];

        DB::transaction(function () use ($products, $categories, $productGroups) {
            foreach ($products as $productData) {
                $images = $productData['images'];
                unset($productData['images']);

                $categoryIndex = $productData['category_index'];
                $groupIndex = $productData['group_index'];
                unset($productData['category_index']);
                unset($productData['group_index']);

                $productData['category_id'] = $categories[$categoryIndex]->id;
                $productData['product_group_id'] = $productGroups[$groupIndex]->id;

                $product = Product::create($productData);

                // Создаем изображения
                foreach ($images as $imageUrl) {
                    $image = new Image();
                    // Сохраняем внешний URL как path (для отображения)
                    $image->path = $imageUrl;
                    $image->type = 'external';
                    $product->images()->save($image);
                }
            }
        });
    }
}
