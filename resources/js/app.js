import './bootstrap';
import { createIcons, Menu, Search, ShoppingCart, Heart, Package, LayoutDashboard, LogOut, Store } from 'lucide';
createIcons({ icons: { Menu, Search, ShoppingCart, Heart, Package, LayoutDashboard, LogOut, Store } });
if ('serviceWorker' in navigator) window.addEventListener('load', () => navigator.serviceWorker.register('/sw.js'));
