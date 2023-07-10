<?php

require_once('helpers/common.php');

?>
<html>
    <head>
        <title>Apirone SDK PHP examples</title>
        <script src="//unpkg.com/alpinejs" defer></script>
        <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
        <link rel="stylesheet" href="https://unpkg.com/@tailwindcss/typography@0.4.1/dist/typography.min.css">
        <link rel="stylesheet" href="https://unpkg.com/@highlightjs/cdn-assets@11.7.0/styles/github-dark.min.css">
        <script src="//unpkg.com/@highlightjs/cdn-assets@11.7.0/highlight.min.js"></script>
        <script>hljs.highlightAll();</script>
        <link rel="icon" href="/helpers/favicon.ico?v=0.0.1">
        <script src="/helpers/script.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body class="flex px-4 bg-white" x-data>
        <div class="container mx-auto max-w-5xl prose prose-base">
            <h1 class="md:pt-16 pt-8 text-center md:text-left">Apirone SDK PHP examples</h1>
            <div>
                <h2>Install via composer</h2>
                <pre><code class="language-bash">composer require apirone-sdk-php</code></pre>
            </div>
            <div>
                <h2>Create database callback function</h2>
                <?php echo load_file_content('db.php'); ?>
            </div>
            <div x-data="table" x-init="load" id="step_2">
                <h2>Invoice data table</h2>
                <?php echo load_file_content('table.php'); ?>
                <button class="text-white rounded-md w-48 bg-sky-500 hover:bg-sky-600 disabled:bg-gray-300 p-2" @click="doAction" x-text="label" :disabled="table"></button>
            </div>
            <div id="step_3">
                <h2>Settings</h2>
                <p>
                    When creating a settings object, you need to create an account, or you can use an existing one.
                    Also, all accessible cryptos of the service are automatically added to the settings object.
                    For invoice you can set only one destination address for each currency. You can set the destination address for each currency right away or do it later. 
                </p>
                <p>
                    You can store the settings in a file or get them as a JSON-object and save them in any way you like.
                    In this example, we will save the settings to a file.<br />
                </p>
                <?php echo load_file_content('settings.php'); ?>

                <div x-data="settings" x-init="load" class="mt-20">
                    <p>Settings config example</p>
                    <div class="relative">
                        <button x-show="file" class="absolute top-4 right-10 text-gray-200" @click="toggle" x-text="expand ? 'Collapse' : 'Expand'"></button>
                        <pre><code class="language-json" :class="{'' : expand, 'max-h-96' : !expand}" x-text="content"></code></pre>
                    </div>
                    <button class="text-white rounded-md w-48 bg-sky-500 hover:bg-sky-700 p-2 disabled:bg-gray-300" @click="doAction" x-text="label" :disabled="file"></button>
                </div>

            </div>
            <div>
                <h2>Apirone callback handler</h2>
                <p>
                    Response processing is important for correct operation of the library.
                    To do this, you need to create a URL that will respond to requests from the apirone service. 
                    There is a special static method for this. You only need to register its call. 
                </p>
                <p>
                    If you want to process invoice statuses for your system, 
                    you need to create a callback function that will handle the changed invoice status.
                </p>
                <?php echo load_file_content('./callback.php'); ?>

            </div>
            <div>
                <h2>Create an invoice</h2>
                <?php echo load_file_content('./invoice.php'); ?>
            </div>
            <div>
                <h2>Show invoice</h2>
                <p>
                    To display an invoice, use <code>Invoice::renderLoader()</code>.<br />
                    You can pass an optional <code>$invoice_id</code> parameter to display an invoice by its ID.
                    If the parameter is not set, the function will try to get it from the GET request parameter "invoice".
                </p>
                <?php echo load_file_content('./render.php'); ?>
                <p>
                    To process ajax requests from the invoice output page, you need to add a request processing page via 
                    <code>Invoice::dataUrl('/render_ajax_response.php');</code> The required parameters will be added by the JS script. 
                    The request is made using the POST method and also has an additional header <code>HTTP_X_REQUESTED_WITH = XMLHttpRequest</code>
                </p>
                <?php echo load_file_content('./render_ajax_response.php'); ?>
            </div>
            <div id="step_5" x-data="playground">
                <h2>Playground</h2>
                <div x-show="!$store.table && !$store.settings" class="pb-16 font-semibold">
                    Before you start working with the playground, you need to create a table and settings.
                </div>
                <div x-show="$store.table && $store.settings" class="pb-10">
                    <div class="class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400">
                        <button @click="active = 0" :class="getClass(0)">Invoice</button>
                        <button @click="active = 1" :class="getClass(1)">Settings</button>
                    </div>
                    <div x-show="active === 1" class="my-8">
                        <form @submit.prevent="create">
                            <div x-if="$store.settings" class="grid md:grid-cols-2 gap-6 grid-cols-1">
                                <label class="block">
                                    <span class="text-gray-700">Invoice title</span>
                                    <input type="text" x-model="$store.settings.title" class="mt-1 block w-full placeholder-gray-400">
                                    <span class="inline-block mt-2 text-gray-400 text-sm">
                                    </span>
                                </label>
                                <label class="block">
                                    <span class="text-gray-700">Invoice lifetime</span>
                                    <input type="number" x-model="$store.settings.timeout" min="0" class="mt-1 block w-full placeholder-gray-400">
                                    <span class="inline-block mt-2 text-gray-400 text-sm">
                                    </span>
                                </label>
                                <label class="block">
                                    <span class="text-gray-700">Merchant name</span>
                                    <input type="text" x-model="$store.settings.merchant" min="0" class="mt-1 block w-full placeholder-gray-400">
                                    <span class="inline-block mt-2 text-gray-400 text-sm">
                                    </span>
                                </label>
                                <label class="block">
                                    <span class="text-gray-700">Merchant URL</span>
                                    <input type="text" x-model="$store.settings.merchantUrl" min="0" class="mt-1 block w-full placeholder-gray-400">
                                    <span class="inline-block mt-2 text-gray-400 text-sm">
                                    </span>
                                </label>
                                <label class="block">
                                    <span class="text-gray-700">Price adjustment</span>
                                    <input x-model="$store.settings.factor" type="number" class="mt-1 block w-full" min="0.01" step="0.01">
                                    <span class="inline-block mt-2 text-gray-400 text-sm">
                                    </span>
                                </label>
                                <label class="block">
                                    <span class="text-gray-700">Back to store URL</span>
                                    <input x-model="$store.settings.backlink" type="text" class="mt-1 block w-full placeholder-gray-400">
                                    <span class="inline-block mt-2 text-gray-400 text-sm">
                                    </span>
                                </label>
                                <label class="block">
                                    <span class="text-gray-700">QR only</span>
                                    <select x-model="$store.settings['qr-only']" class="block w-full mt-1">
                                        <option value="true">Yes</option>
                                        <option value="false">No</option>
                                    </select>
                                    <span class="inline-block mt-2 text-gray-400 text-sm no-prose">
                                    </span>
                                </label>
                                <label class="block">
                                    <span class="text-gray-700">Show Apirone logo</span>
                                    <select x-model="$store.settings.logo" class="block w-full mt-1">
                                        <option value="true">Yes</option>
                                        <option value="false">No</option>
                                    </select>
                                    <span class="inline-block mt-2 text-gray-400 text-sm">
                                    </span>
                                </label>
                                <label class="block">
                                    <span class="text-gray-700">Debug mode</span>
                                    <select x-model="$store.settings.debug" class="block w-full mt-1">
                                        <option value="true">Yes</option>
                                        <option value="false">No</option>
                                    </select>
                                    <span class="inline-block mt-2 text-gray-400 text-sm">
                                    </span>
                                </label>
                            </div>
                            <div class="border-t-2 mt-6 pt-4">
                                <button type="submit" class="text-white rounded-md md:w-48 w-full bg-sky-500 hover:bg-sky-600 disabled:bg-gray-300 disabled:text-gray-600 p-4 mr-2 my-2" @click="$event.prevent; save" x-text="settingsLabel"></button>
                            </div>
                            <h3>Settings</h3>
                            <div class="relative">
                                <button x-show="invoice" class="absolute top-4 right-10 text-gray-200" @click.prevent="toggle" x-text="expand ? 'Collapse' : 'Expand'"></button>
                                <pre><code class="language-json" :class="{'' : expand, 'max-h-96' : !expand}" x-text="JSON.stringify($store.settings, null, 2)"></code></pre>
                            </div>

                        </form>
                    </div>
                    <div x-show="active === 0" class="my-8">
                        <form @submit.prevent="create">
                            <div class="grid md:grid-cols-2 gap-6 grid-cols-1">
                                <label class="block">
                                    <span class="text-gray-700">Currency <span class="text-red-500">*</span></span>
                                    <select x-model="data.currency" class="block w-full mt-1">
                                        <option value="" class="text-gray-400">Select currency</option>
                                        <template x-if="$store.settings">
                                            <template x-for="currency in $store.settings.currencies">
                                                <option x-text="currency.abbr"></option>
                                            </template>
                                        </template>
                                    </select>
                                    <span class="inline-block mt-2 text-gray-400 text-sm">
                                        Currency type (any cryptocurrency supported by service). Required	
                                    </span>
                                </label>
                                <label class="block">
                                    <span class="text-gray-700">Amount</span>
                                    <input type="number" x-model="data.amount" min="0" class="mt-1 block w-full placeholder-gray-400" placeholder="Enter amount value in minor units">
                                    <span class="inline-block mt-2 text-gray-400 text-sm">
                                        Amount for the checkout in the selected currency of the invoice object. Also you may create invoices without fixed amount. The amount is indicated in minor units	
                                    </span>
                                </label>
                                <label class="block">
                                    <span class="text-gray-700">Lifetime</span>
                                    <input x-model="data.lifetime" type="number" class="mt-1 block w-full" min="0" value="300">
                                    <span class="inline-block mt-2 text-gray-400 text-sm">
                                        Duration of invoice validity (indicated in seconds)	
                                    </span>
                                </label>
                                <label class="block">
                                    <span class="text-gray-700">Expire</span>
                                    <input x-model="data.expire" type="text" class="mt-1 block w-full" min="0" value="300">
                                    <span class="inline-block mt-2 text-gray-400 text-sm no-prose">
                                        Invoice expiration time in <a href="https://www.iso.org/iso-8601-date-and-time-format.html" target="_blank" class="not-prose text-gray-400 hover:text-gray-500">ISO-8601</a> format, for example, 2022-02-22T09:00:30. 
                                        If both parameters are specified: lifetime and expire, then the parameter expire will take precedence
                                    </span>
                                </label>
                                <label class="block">
                                    <span class="text-gray-700">Callback URL</span>
                                    <input x-model="data.callbackUrl" type="text" class="mt-1 block w-full placeholder-gray-400" placeholder="https://yourhost.com/callback.php">
                                    <span class="inline-block mt-2 text-gray-400 text-sm">
                                        Enter the protocol and domain name or IP address of your host and add /callback.php for the example to work correctly.
                                        Your host must be accessible from the internet.
                                    </span>
                                </label>
                                <label class="block">
                                    <span class="text-gray-700">Linkback</span>
                                    <input x-model="data.callbackUrl" type="text" class="mt-1 block w-full placeholder-gray-400" placeholder="https://linkback.com">
                                    <span class="inline-block mt-2 text-gray-400 text-sm">
                                        The customer will be redirected to this URL after the payment is completed
                                    </span>
                                </label>
                            </div>
                            <div>
                                <label _x-show="invoice">Add User Data<input class="mx-2 my-4" type="checkbox" x-model="showUserData" /></label>
                                <div x-show="showUserData" x-transition class="" >
                                    <h3>Main section</h3>
                                    <div class="grid grid-cols-2 gap-6 mb-6">
                                        <label class="block">
                                            <span class="text-gray-700">Invoice title</span>
                                            <input x-model="userData.title" type="text" class="mt-1 block w-full">
                                            <span class="inline-block mt-2 text-gray-400 text-sm">Custom title for invoice</span>
                                        </label>
                                        <label class="block">
                                            <span class="text-gray-700">Merchant name</span>
                                            <input x-model="userData.merchant" type="text" class="mt-1 block w-full">
                                            <span class="inline-block mt-2 text-gray-400 text-sm">For example, the name of your store</span>
                                        </label>
                                        <label class="block">
                                            <span class="text-gray-700">Merchant url</span>
                                            <input x-model="userData.url" type="text" class="mt-1 block w-full">
                                            <span class="inline-block mt-2 text-gray-400 text-sm">URL to merchant's site</span>
                                        </label>
                                        <label class="block">
                                            <span class="text-gray-700">Price (total)</span>
                                            <input x-model="userData.price" type="text" class="mt-1 block w-full">
                                            <span class="inline-block mt-2 text-gray-400 text-sm">Displays the total price in fiat</span>
                                        </label>
                                        <label class="block">
                                            <span class="text-gray-700">Sub-price (sub total)</span>
                                            <input x-model="userData['sub-price']" type="text" class="mt-1 block w-full">
                                            <span class="inline-block mt-2 text-gray-400 text-sm">Displays amount in fiat before adding discount, tax or shipping charges</span>
                                        </label>
                                    </div>
                                    <h3>Items section</h3>
                                    <template x-for="(item, index) in userData.items">
                                        <div class="grid md:grid-cols-4 grid-cols-2 gap-6 mb-6">
                                            <label class="block">
                                                <span class="text-gray-700">Name</span>
                                                <input x-model="item.name" type="text" class="mt-1 block w-full">
                                                <span class="inline-block mt-2 text-gray-400 text-sm">Item name</span>
                                            </label>
                                            <label class="block">
                                                <span class="text-gray-700">Cost</span>
                                                <input x-model="item.cost" type="text" class="mt-1 block w-full">
                                                <span class="inline-block mt-2 text-gray-400 text-sm">Item cost</span>
                                            </label>
                                            <label class="block">
                                                <span class="text-gray-700">Qty</span>
                                                <input x-model="item.qty" type="text" class="mt-1 block w-full">
                                                <span class="inline-block mt-2 text-gray-400 text-sm">Items quantity</span>
                                            </label>
                                            <label class="block">
                                                <span class="text-gray-700">Total</span>
                                                <input x-model="item.total" type="text" class="mt-1 block w-full">
                                                <span class="inline-block mt-2 text-gray-400 text-sm">The total fiat price</span>
                                            </label>
                                        </div>
                                    </template>
                                    <button type="button" class="text-white rounded-md w-20 bg-green-500 hover:bg-green-600 p-2 mr-2 my-2" @click="addItem">Add</button>
                                    <button x-show="userData.items.length > 0" type="button" class="text-white rounded-md w-20 bg-gray-400 hover:bg-gray-500 disabled:bg-gray-200 p-2 mr-2 my-2" @click="userData.items=[]">Clear</button>
                                    <h3>Extras section</h3>
                                    <template x-for="(item, index) in userData.extras">
                                        <div class="grid md:grid-cols-2 grid-cols-1 gap-6 mb-6">
                                            <label class="block">
                                                <span class="text-gray-700">Name</span>
                                                <input x-model="item.name" type="text" class="mt-1 block w-full">
                                                <span class="inline-block mt-2 text-gray-400 text-sm">Item name</span>
                                            </label>
                                            <label class="block">
                                                <span class="text-gray-700">Price</span>
                                                <input x-model="item.price" type="text" class="mt-1 block w-full">
                                                <span class="inline-block mt-2 text-gray-400 text-sm">Item price</span>
                                            </label>
                                        </div>
                                    </template>
                                    <button type="button" class="text-white rounded-md w-20 bg-green-500 hover:bg-green-600 p-2 mr-2 my-2" @click="addExtra">Add</button>
                                    <button x-show="userData.extras.length > 0" type="button" class="text-white rounded-md w-20 bg-gray-400 hover:bg-gray-500 disabled:bg-gray-200 p-2 mr-2 my-2" @click="userData.extras=[]">Clear</button>
                                </div>
                            <div class="border-t-2 mt-6 pt-4">
                                <span class="block mb-8"><span class="text-red-500">*</span> - Required fields</span>
                                <button type="submit" :disabled="!data.currency" class="text-white rounded-md md:w-48 w-full bg-sky-500 hover:bg-sky-600 disabled:bg-gray-300 disabled:text-gray-600 p-4 mr-2 my-2" @click="$event.prevent; create" x-text="label"></button>
                                <button type="button" x-show="invoice" class="text-white rounded-md md:w-48 w-full bg-sky-500 hover:bg-sky-600 disabled:bg-gray-300 p-4 my-2" @click="render">Show invoice</button>
                                <label x-show="invoice">QR Only<input class="mx-2" type="checkbox" x-model="qrOnly" /></label>
                            </div>
                            <h3>Invoice details</h3>
                            <div class="relative">
                                <button x-show="invoice" class="absolute top-4 right-10 text-gray-200" @click.prevent="toggle" x-text="expand ? 'Collapse' : 'Expand'"></button>
                                <pre><code class="language-json" :class="{'' : expand, 'max-h-96' : !expand}" x-text="content"></code></pre>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>