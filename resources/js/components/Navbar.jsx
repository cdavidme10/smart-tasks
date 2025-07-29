import { Link, useLocation } from "react-router-dom";
import { useTranslation } from "react-i18next";

export default function Navbar() {
    const { pathname } = useLocation();
    const { t } = useTranslation();

    const linkClass = (path) =>
        pathname === path
            ? "text-blue-500 font-semibold"
            : "text-gray-600 hover:text-blue-500";

    return (
        <nav className="bg-white shadow p-4 flex justify-between items-center">
            <h1 className="text-xl font-bold text-gray-800">SmartTasks</h1>
            <div className="space-x-4">
                <Link to="/" className={linkClass("/")}>
                    {t("navbar.home")}
                </Link>
                <Link to="/about" className={linkClass("/about")}>
                    {t("navbar.about")}
                </Link>
            </div>
        </nav>
    );
}
