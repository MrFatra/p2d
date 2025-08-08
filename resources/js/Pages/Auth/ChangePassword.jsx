import { useForm, usePage } from '@inertiajs/react'

const ChangePassword = () => {
    const { flash } = usePage().props

    const { data, setData, post, processing, errors } = useForm({
        password: '',
        password_confirmation: '',
    })

    const handleSubmit = (e) => {
        e.preventDefault()
        post(route('password.change'))
    }

    return (
        <div className="min-h-screen bg-gray-50 flex items-center justify-center px-4">
            <div className="bg-white shadow-lg rounded-2xl p-8 w-full max-w-md">
                <h1 className="text-3xl font-bold text-center text-[#008970] mb-2">Ubah Password</h1>
                <p className="text-gray-600 text-center mb-6 text-sm">
                    Silakan masukkan password baru Anda.
                </p>

                {flash.success && (
                    <div className="text-green-500 text-sm mb-4 text-center">
                        {flash.success}
                    </div>
                )}

                <form onSubmit={handleSubmit}>

                    <div className="mb-4">
                        <label className="block text-sm font-medium text-gray-700 mb-1">
                            Password Baru
                        </label>
                        <input
                            type="password"
                            className={`shadow border ${errors.password ? 'border-red-500' : 'border-gray-300 focus:border-custom-emerald focus:ring-custom-emerald focus:ring-1'} rounded-lg w-full p-3 mb-3 leading-tight focus:outline-none font-medium md:text-base text-sm`}
                            value={data.password}
                            onChange={(e) => setData('password', e.target.value)}
                            required
                        />
                        {errors.password && (
                            <div className="text-red-500 text-sm mt-1">{errors.password}</div>
                        )}
                    </div>

                    <div className="mb-6">
                        <label className="block text-sm font-medium text-gray-700 mb-1">
                            Konfirmasi Password
                        </label>
                        <input
                            type="password"
                            className={`shadow border ${errors.password ? 'border-red-500' : 'border-gray-300 focus:border-custom-emerald focus:ring-custom-emerald focus:ring-1'} rounded-lg w-full p-3 mb-3 leading-tight focus:outline-none font-medium md:text-base text-sm`}
                            value={data.password_confirmation}
                            onChange={(e) => setData('password_confirmation', e.target.value)}
                            required
                        />
                        {errors.password_confirmation && (
                            <div className="text-red-500 text-sm mt-1">{errors.password_confirmation}</div>
                        )}
                    </div>

                    <button
                        type="submit"
                        disabled={processing}
                        className={`flex gap-2 items-center justify-center w-full ${processing && 'bg-shades/70 disabled:cursor-not-allowed disabled:opacity-60'} bg-shades hover:bg-emerald-800 text-white font-semibold py-3 rounded-md transition duration-200`}
                    >
                        {
                            processing
                                ?
                                <>
                                    <span className="h-4 w-4 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
                                    <span>Loading</span>
                                </>
                                :
                                'Ganti Password'
                        }
                    </button>
                </form>
            </div>
        </div>
    )
}

export default ChangePassword
