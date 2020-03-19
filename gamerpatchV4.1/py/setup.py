from setuptools import setup, find_packages

requirements = [line for line in open("./requirements.txt").readlines()]

setup(
    name="gamerpatch",
    version="0.1",
    packages=find_packages(),
    package_dir={"gamerpatch": "gamerpatch"},
    install_requirements=requirements,
    include_package_data=True,
)
