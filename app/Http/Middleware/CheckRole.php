Route::get('/menus', [MenuController::class, 'index'])->middleware('role:admin,manager');
