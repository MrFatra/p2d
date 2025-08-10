import { BiLogIn } from "react-icons/bi";
import { useEffect, useState } from "react";
import { Head, useForm, usePage } from "@inertiajs/react";
import { useToast } from "../../components/Toast/ToastProvider";

const Login = () => {
    const { flash } = usePage().props
    const { addToast } = useToast()

    const { data, setData, post, processing, errors } = useForm({
        national_id: '',
        password: '',
    })

    const [visiblePass, setVisiblePass] = useState(false);

    const handleSubmit = (e) => {
        e.preventDefault()
        post(route('login'))
    }

    useEffect(() => {
        if (flash?.success) {
            addToast({ title: 'Success', message: flash.success, type: 'success', variant: 'outline', position: 'topRight' })
        }

        if (flash?.error) {
            addToast({ title: 'Success', message: flash.error, type: 'error', variant: 'outline', position: 'topRight' })
        }
    }, [flash]);


    return (
        <>
            <Head title="Login"/>
            <div className="flex items-center justify-center h-screen w-screen">
                <div className="w-1/2 h-full bg-gray-200 lg:block hidden">
                    <img
                        src="https://placehold.co/100"
                        alt=""
                        className="object-cover w-full h-full"
                    />
                </div>
                <div className="flex flex-col justify-center lg:w-1/2 lg:h-full text-foreground lg:px-20 lg:py-0 lg:border-0 border border-shades/20 lg:shadow-none shadow-lg lg:rounded-none rounded-xl md:p-10 p-5">
                    <p className="text-shades font-bold text-2xl md:text-3xl lg:text-start text-center">
                        {import.meta.env.VITE_APP_NAME.toUpperCase()}
                    </p>
                    <p className="text-lg md:text-2xl font-bold mt-5">
                        Selamat Datang!
                    </p>
                    <p className="text-gray-500 mb-5 text-sm">
                        Silahkan isi form dibawah ini.
                    </p>

                    <form onSubmit={handleSubmit} className="flex flex-col w-full">
                        <div className="mb-4">
                            <label
                                className="block md:text-sm text-xs font-bold mb-2 text-gray-500"
                                htmlFor="national_id"
                            >
                                NIK
                            </label>
                            <input
                                className={`shadow border ${errors.national_id ? 'border-red-500' : 'border-gray-300 focus:border-custom-emerald focus:ring-custom-emerald focus:ring-1'} rounded-lg w-full p-3 mb-3 leading-tight focus:outline-none font-medium md:text-base text-sm`}
                                id="national_id"
                                type="number"
                                value={data.national_id}
                                onChange={(e) => {
                                    setData('national_id', e.target.value)
                                    if (errors.national_id) errors.national_id = null
                                }}

                            />
                            {
                                errors.national_id &&
                                <p className="text-red-500 text-xs italic">
                                    {errors.national_id}
                                </p>
                            }
                        </div>

                        <div className="mb-6">
                            <label
                                className="block text-sm font-bold mb-2 text-gray-500"
                                htmlFor="password"
                            >
                                Password
                            </label>
                            <input
                                className={`shadow border ${errors.password ? 'border-red-500' : 'border-gray-300 focus:border-custom-emerald focus:ring-custom-emerald focus:ring-1'} rounded-lg w-full p-3 mb-3 leading-tight focus:outline-none font-medium md:text-base text-sm`}
                                id="password"
                                type={visiblePass ? "text" : "password"}
                                value={data.password}
                                onChange={(e) => {
                                    setData('password', e.target.value)
                                    if (errors.password) errors.password = null
                                }}

                            />
                            {
                                errors.password &&
                                <p className="text-red-500 text-xs italic">
                                    {errors.password}
                                </p>
                            }
                        </div>

                        <div className="flex justify-between items-center mb-10 mt-2">
                            <div className="inline-flex items-center">
                                <label className="relative flex cursor-pointer items-center rounded-full mr-3">
                                    <input
                                        id="seePass"
                                        type="checkbox"
                                        className="peer relative md:h-5 md:w-5 w-4 h-4 cursor-pointer appearance-none rounded border border-slate-300 shadow hover:shadow-md transition-all before:absolute before:top-2/4 before:left-2/4 before:block before:h-12 before:w-12 before:-translate-y-2/4 before:-translate-x-2/4 before:rounded-full before:bg-slate-400 before:opacity-0 before:transition-opacity checked:border-shades checked:bg-shades checked:before:bg-slate-400 hover:before:opacity-10"
                                        onChange={(v) =>
                                            setVisiblePass(v.target.checked)
                                        }
                                    />
                                    <span className="pointer-events-none absolute top-2/4 left-2/4 -translate-y-2/4 -translate-x-2/4 text-white opacity-0 transition-opacity peer-checked:opacity-100">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            className="h-3.5 w-3.5"
                                            viewBox="0 0 20 20"
                                            fill="currentColor"
                                            stroke="currentColor"
                                            strokeWidth="1"
                                        >
                                            <path
                                                fillRule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clipRule="evenodd"
                                            ></path>
                                        </svg>
                                    </span>
                                </label>
                                <label
                                    htmlFor="seePass"
                                    className="cursor-pointer md:text-sm text-xs font-medium text-gray-500"
                                >
                                    Lihat Password
                                </label>
                            </div>
                            <a
                                className="inline-block align-baseline font-bold md:text-sm text-xs text-shades hover:underline"
                                href={route('password.index')}
                            >
                                Lupa Password?
                            </a>
                        </div>

                        <button
                            className={`flex w-full items-center justify-center gap-1 bg-shades ${processing && 'bg-shades/70 disabled:cursor-not-allowed'} hover:bg-emerald-800 hover:cursor-pointer text-white font-bold py-3 rounded-lg focus:outline-none focus:shadow-outline md:text-base text-sm disabled:opacity-60 duration-200`}
                            type="submit"
                            disabled={processing}
                        >
                            {processing ? (
                                <>
                                    <span className="h-4 w-4 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
                                    <span>Loading</span>
                                </>
                            ) : (
                                <>
                                    <span>Login</span>
                                    <BiLogIn className="text-xl" />
                                </>
                            )}
                        </button>

                    </form>
                </div>
            </div>
        </>
    );
};

export default Login;
