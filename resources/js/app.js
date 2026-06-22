import './bootstrap';
import {
  createIcons,
  ArrowUpRight,
  ChevronDown,
  Grid3X3,
  Heart,
  Home,
  LayoutDashboard,
  LogOut,
  Mail,
  MapPin,
  Menu,
  MessageCircle,
  Package,
  Phone,
  Search,
  ShoppingCart,
  SlidersHorizontal,
  Store,
  X,
} from 'lucide';

createIcons({
  icons: {
    ArrowUpRight,
    ChevronDown,
    Grid3X3,
    Heart,
    Home,
    LayoutDashboard,
    LogOut,
    Mail,
    MapPin,
    Menu,
    MessageCircle,
    Package,
    Phone,
    Search,
    ShoppingCart,
    SlidersHorizontal,
    Store,
    X,
  },
});

window.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('[data-toggle-menu]').forEach((button) => {
    button.addEventListener('click', () => {
      document.querySelector('[data-mobile-menu]')?.classList.toggle('hidden');
    });
  });

  document.querySelectorAll('[data-close-menu]').forEach((button) => {
    button.addEventListener('click', () => {
      document.querySelector('[data-mobile-menu]')?.classList.add('hidden');
    });
  });

  document.querySelectorAll('[data-category-toggle]').forEach((button) => {
    button.addEventListener('click', () => {
      const target = document.querySelector(button.getAttribute('data-category-toggle'));
      target?.classList.toggle('hidden');
      button.querySelector('[data-chevron]')?.classList.toggle('rotate-180');
    });
  });
});

if ('serviceWorker' in navigator) window.addEventListener('load', () => navigator.serviceWorker.register('/sw.js'));
